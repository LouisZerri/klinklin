<template>
    <!-- Filtres -->
    <div class="invoices-filters mb-4">
        <div class="filters-row">
            <div class="filter-item">
                <input type="month" v-model="filters.month" class="form-control" placeholder="Mois">
            </div>
            <div class="filter-item">
                <input type="text" v-model="filters.search" class="form-control"
                    placeholder="Rechercher une facture...">
            </div>
        </div>
    </div>

    <!-- Liste des factures -->
    <div class="invoices-grid" v-if="filteredInvoices.length > 0">
        <div v-for="invoice in filteredInvoices" :key="invoice.id" class="invoice-card">
            <div class="invoice-header">
                <div class="invoice-status">
                    <span class="status-badge">
                        <i class="fa-solid fa-circle-check"></i>
                        Payée
                    </span>
                </div>
                <div class="invoice-number">
                    <strong>{{ invoice.reference }}</strong>
                </div>
            </div>

            <div class="invoice-body">
                <div class="invoice-details">
                    <div class="detail-item">
                        <span class="label">Date d'émission</span>
                        <span class="value">{{ formatDate(invoice.invoice_date) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Montant</span>
                        <span class="value amount">{{ formatAmount(invoice.total) }}</span>
                    </div>
                </div>
            </div>

            <div class="invoice-footer">
                <button class="btn btn-purple-dashboard" @click="downloadInvoice(invoice)"
                    :disabled="invoice.downloading">
                    <i class="fas fa-download" v-if="!invoice.downloading"></i>
                    <i class="fas fa-spinner fa-spin" v-else></i>
                    {{ invoice.downloading ? 'Téléchargement...' : 'Télécharger PDF' }}
                </button>
            </div>
        </div>
    </div>

    <!-- Message si aucune facture -->
    <div class="no-invoices" v-else>
        <div class="text-center py-5">
            <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">
                {{ filters.search || filters.month ? 'Aucune facture correspondante' : 'Aucune facture trouvée' }}
            </h4>
            <p class="text-muted">
                {{ filters.search || filters.month ? 'Essayez de modifier vos critères de recherche.'
                    : 'Vos factures apparaîtront ici une fois vos commandes traitées.' }}
            </p>
            <button v-if="filters.search || filters.month" @click="clearFilters" class="btn btn-outline-purple mt-3">
                Effacer les filtres
            </button>
        </div>
    </div>

</template>

<script setup>
import { ref, computed } from 'vue'

// Props
const props = defineProps({
    invoices: {
        type: Array,
        required: true
    },
    downloadUrl: {
        type: String,
        required: true
    },
    checkUrl: {
        type: String,
        required: false
    }
})

// État réactif
const filters = ref({
    month: '',
    search: ''
})

// Computed properties
const filteredInvoices = computed(() => {
    let result = props.invoices || []

    // Filtre par mois
    if (filters.value.month) {
        result = result.filter(invoice => {
            const invoiceMonth = invoice.invoice_date.substring(0, 7)
            return invoiceMonth === filters.value.month
        })
    }

    // Filtre par recherche
    if (filters.value.search) {
        const searchTerm = filters.value.search.toLowerCase()
        result = result.filter(invoice =>
            invoice.reference.toLowerCase().includes(searchTerm)
        )
    }

    return result
})

const formatDate = (dateString) => {
    if (!dateString) return 'Date non disponible'
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }
    return new Date(dateString).toLocaleDateString('fr-FR', options)
}

const formatAmount = (amount) => {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR'
    }).format(amount)
}

const clearFilters = () => {
    filters.value = {
        month: '',
        search: ''
    }
}

const downloadInvoice = async (invoice) => {
    invoice.downloading = true

    try {
        // Vérifier d'abord si la facture est disponible
        if (props.checkUrl) {
            const checkResponse = await fetch(props.checkUrl.replace(':id', invoice.id))
            const checkData = await checkResponse.json()

            if (!checkData.available) {
                throw new Error(checkData.error || 'Facture non disponible')
            }
        }

        // Créer l'URL de téléchargement
        const downloadLink = props.downloadUrl.replace(':id', invoice.id)

        // Redirection simple (recommandée pour les PDFs)
        window.location.href = downloadLink

    } catch (error) {
        console.error('Erreur lors du téléchargement:', error)
        alert('Erreur lors du téléchargement de la facture: ' + error.message)
    } finally {
        // Délai pour l'UX
        setTimeout(() => {
            invoice.downloading = false
        }, 1000)
    }
}
</script>