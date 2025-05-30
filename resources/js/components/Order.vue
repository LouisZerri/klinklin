<template>
    <div class="filter-container">
        <button v-for="filter in filters" :key="filter.label"
            :class="['filter-button', activeFilter === filter.value && 'filter-button-active']"
            @click="setFilter(filter.value)">
            <span class="button-text">{{ filter.label }}</span>
            <span class="chevron-down"></span>
        </button>
    </div>

    <div v-if="filteredOrders.length > 0" class="card-grid">
        <div class="order-card" v-for="order in filteredOrders" :key="order.id">
            <div :class="getStatusClass(order.status)">
                <span :class="getDotClass(order.status)"></span>
                <span class="order-label">{{ order.status }}</span>
            </div>

            <div class="order-content">
                <div class="order-header">
                    <div class="order-text-block">
                        <div class="order-title">Commande {{ order.order_number }}</div>
                        <div class="order-date">Date: {{ formatDate(order.order_date) }}</div>
                    </div>
                    <div class="order-amount">{{ formatTotal(order) }}</div>
                </div>

                <div class="order-footer">
                    <button class="order-details-button">Voir détails</button>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="no-orders-message">
        Aucune commande à afficher pour ce statut.
    </div>

    <a href="/collecte" class="btn btn-purple-dashboard mt-5">
        Planifier une nouvelle commande <i class="fa-solid fa-plus ms-2"></i>
    </a>
</template>

<script setup>
import { ref, computed } from 'vue'

const filters = [
    { label: 'Tous', value: 'Tous' },
    { label: 'En attente de collecte', value: 'En attente' },
    { label: 'En nettoyage', value: 'En nettoyage' },
    { label: 'En cours de livraison', value: 'En cours de livraison' },
    { label: 'Livré', value: 'Livré' },
    { label: 'Annulée', value: 'Annulée' },
]

const activeFilter = ref('Tous')

// Props
const props = defineProps({
    orders: {
        type: Array,
        required: true
    }
})

function setFilter(value) {
    activeFilter.value = value
}

function formatDate(dateString) {
    const date = new Date(dateString)
    const day = String(date.getDate()).padStart(2, '0')
    const month = String(date.getMonth() + 1).padStart(2, '0')
    const year = date.getFullYear()
    return `${day}/${month}/${year}`
}

function formatTotal(order) {
    const subtotal = parseFloat(order.subtotal) || 0
    const expedition = parseFloat(order.expedition) || 0
    const tax = parseFloat(order.tax) || 0
    const total = subtotal + expedition + tax

    return total.toLocaleString('fr-FR', {
        style: 'currency',
        currency: 'EUR'
    })
}

function getStatusClass(status) {
    switch (status?.toLowerCase()) {
        case 'en attente':
            return 'order-status-yellow'
        case 'livré':
            return 'order-status-green'
        case 'annulée':
            return 'order-status-red'
        default:
            return 'order-status-blue'
    }
}

function getDotClass(status) {
    switch (status?.toLowerCase()) {
        case 'en attente':
            return 'order-dot-yellow'
        case 'livré':
            return 'order-dot-green'
        case 'annulée':
            return 'order-dot-red'
        default:
            return 'order-dot-blue'
    }
}

const filteredOrders = computed(() => {
    if (activeFilter.value === 'Tous') {
        return props.orders
    }
    return props.orders.filter(order =>
        order.status?.toLowerCase() === activeFilter.value.toLowerCase()
    )
})
</script>
