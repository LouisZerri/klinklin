<template>
    <div class="payment-container">
        <!-- Statistiques rapides -->
        <div class="stats-overview">
            <div class="stat-card">
                <div class="stat-value">{{ filteredOrders.length }}</div>
                <div class="stat-label">Transactions</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ calculateTotalAmount() }}€</div>
                <div class="stat-label">Montant total</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ calculateTotalItems() }}</div>
                <div class="stat-label">Articles choisis</div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="filters">
            <select v-model="selectedPeriod" class="filter-select">
                <option value="">Toutes les périodes</option>
                <option value="7">7 derniers jours</option>
                <option value="30">30 derniers jours</option>
                <option value="90">3 derniers mois</option>
                <option value="365">Cette année</option>
            </select>

            <input type="text" v-model="searchTerm" placeholder="🔍 Rechercher par référence..." class="form-control">
        </div>

        <!-- Tableau -->
        <div class="payment-table-wrapper" v-if="paginatedOrders.length > 0">
            <table class="payment-table">
                <thead>
                    <tr>
                        <th>Référence facture</th>
                        <th>Date de commande</th>
                        <th>Montant payé</th>
                        <th>Quantité d'articles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in paginatedOrders" :key="order.order_id" class="table-row">
                        <td>
                            <span class="reference-code" @click="copyToClipboard(order.invoice_reference)">
                                {{ order.invoice_reference }}
                            </span>
                        </td>
                        <td>
                            <div class="date-cell">
                                <span class="date-main">{{ formatDate(order.invoice_date) }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="amount">{{ formatAmount(order.total_amount) }}€</span>
                        </td>
                        <td>
                            <span class="quantity-badge">{{ order.total_quantity || 0 }} article(s)</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a :href="orderId.replace(':id', order.order_id)" class="btn btn-view">
                                    👁️ Voir
                                </a>
                                <button @click="downloadInvoice(order)" class="btn-download"
                                    :disabled="order.downloading">
                                    <span v-if="order.downloading">⏳</span>
                                    <span v-else>📄</span>
                                    {{ order.downloading ? 'Téléchargement...' : 'Facture' }}
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Votre composant pagination -->
        <Pagination v-if="filteredOrders.length > itemsPerPage" :current-page="currentPage"
            :total-items="filteredOrders.length" :items-per-page="itemsPerPage" :item-label="'transactions'"
            :show-info="true" :scroll-target="'.payment-table-wrapper'" @page-change="handlePageChange" />

        <!-- Message si aucune commande -->
        <div v-else-if="filteredOrders.length === 0" class="no-orders-message">
            Aucune commande à afficher
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import Pagination from './Pagination.vue'

// Props
const props = defineProps({
    orders: {
        type: Array,
        required: true,
        default: () => []
    },
    orderId: {
        type: String,
        required: true
    },
    downloadUrl: {
        type: String,
        required: true
    },
    checkUrl: {
        type: String,
        default: null
    }
})

// Émissions d'événements
const emit = defineEmits(['view-order', 'download-invoice'])

// States
const selectedPeriod = ref('')
const searchTerm = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Helpers
const formatDate = (dateStr) => {
    if (!dateStr) return ''
    const date = new Date(dateStr)
    return isNaN(date) ? '' : date.toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    })
}

const formatAmount = (amount) => {
    const numAmount = Number(amount)
    return isNaN(numAmount) ? '0.00' : numAmount.toFixed(2)
}

function cleanDate(rawDate) {
    if (!rawDate) return null

    let date
    if (typeof rawDate === 'string') {
        date = new Date(rawDate)
    } else if (rawDate instanceof Date) {
        date = rawDate
    } else {
        return null
    }

    return isNaN(date.getTime()) ? null : date
}

// Calculer le montant total
const calculateTotalAmount = () => {
    return filteredOrders.value.reduce((total, order) => {
        return total + Number(order.total_amount || 0)
    }, 0).toFixed(2)
}

// Calculer le nombre total d'articles
const calculateTotalItems = () => {
    return filteredOrders.value.reduce((total, order) => {
        return total + Number(order.total_quantity || 0)
    }, 0)
}

// Filtres et tri
const filteredOrders = computed(() => {
    let filtered = [...props.orders]

    // Filtre par période
    if (selectedPeriod.value) {
        const days = parseInt(selectedPeriod.value)

        const orderDates = props.orders
            .map(order => cleanDate(order.invoice_date))
            .filter(date => date !== null)
            .sort((a, b) => b.getTime() - a.getTime())

        const latestOrderDate = orderDates.length > 0 ? orderDates[0] : new Date()

        // Utiliser la date la plus récente entre "maintenant" et la dernière commande
        const referenceDate = new Date(Math.max(new Date().getTime(), latestOrderDate.getTime()))
        referenceDate.setHours(23, 59, 59, 999)

        // Calculer la date limite
        const limitDate = new Date(referenceDate)
        limitDate.setDate(referenceDate.getDate() - days)
        limitDate.setHours(0, 0, 0, 0)

        filtered = filtered.filter((order) => {
            const orderDate = cleanDate(order.invoice_date)
            if (!orderDate) {
                return false
            }

            // Normaliser la date de commande
            const normalizedOrderDate = new Date(orderDate)
            normalizedOrderDate.setHours(12, 0, 0, 0)

            const isInPeriod = normalizedOrderDate >= limitDate && normalizedOrderDate <= referenceDate

            return isInPeriod
        })
    }

    // Filtre par recherche
    if (searchTerm.value) {
        const search = searchTerm.value.toLowerCase()
        filtered = filtered.filter((order) => {
            return order.invoice_reference?.toLowerCase().includes(search) ||
                order.order_id?.toString().includes(search)
        })
    }

    console.log('Commandes filtrées:', filtered.length)
    return filtered
})

// Pagination - ajout des computed pour votre composant pagination
const paginatedOrders = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value
    const end = start + itemsPerPage.value
    return filteredOrders.value.slice(start, end)
})

// Gestion du changement de page - ajout de cette fonction
const handlePageChange = (newPage) => {
    currentPage.value = newPage
}

const downloadInvoice = async (order) => {
    order.downloading = true

    try {
        // Vérifier d'abord si la facture est disponible
        if (props.checkUrl) {
            const checkResponse = await fetch(props.checkUrl.replace(':id', order.order_id))
            const checkData = await checkResponse.json()

            if (!checkData.available) {
                throw new Error(checkData.error || 'Facture non disponible')
            }
        }

        // Créer l'URL de téléchargement
        const downloadLink = props.downloadUrl.replace(':id', order.order_id)

        // Redirection simple (recommandée pour les PDFs)
        window.location.href = downloadLink

    } catch (error) {
        console.error('Erreur lors du téléchargement:', error)
        alert('Erreur lors du téléchargement de la facture: ' + error.message)
    } finally {
        // Délai pour l'UX
        setTimeout(() => {
            order.downloading = false
        }, 1000)
    }
}

// Réinitialiser la pagination quand les filtres changent
const resetPagination = () => {
    currentPage.value = 1
}

// Watchers pour réinitialiser la pagination
watch([selectedPeriod, searchTerm], resetPagination)

</script>