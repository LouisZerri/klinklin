<template>
    <div class="history">
        <!-- Filtres -->
        <div class="history-filters">
            <div class="history-select">
                <select v-model="period">
                    <option value="">Périodes</option>
                    <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                </select>
            </div>
            <div class="history-select">
                <select v-model="status">
                    <option value="">Statut</option>
                    <option v-for="s in statuses" :key="s" :value="s">{{ s }}</option>
                </select>
            </div>
        </div>

        <!-- Tableau -->
        <div class="history-table-wrapper">
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Date de collecte</th>
                        <th>Montant payé</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in filteredOrders" :key="order.id">
                        <td>{{ order.order_number }}</td>
                        <td>{{ formatDate(order.order_date) }}</td>
                        <td>{{ formatAmount(order) }}</td>
                        <td>
                            <span class="history-badge" :class="badgeClass(order.status)">
                                <span class="history-dot"></span>{{ order.status }}
                            </span>
                        </td>
                    </tr>
                    <tr v-if="filteredOrders.length === 0">
                        <td colspan="4" class="history-empty">Aucune commande pour ces critères.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
    orders: {
        type: Array,
        required: true,
    },
})

const period = ref('')
const status = ref('')

const getYear = (dateString) => new Date(dateString).getFullYear()

const years = computed(() => {
    const set = new Set(props.orders.map((o) => getYear(o.order_date)))
    return [...set].sort((a, b) => b - a)
})

const statuses = computed(() => {
    const set = new Set(props.orders.map((o) => o.status))
    return [...set]
})

const filteredOrders = computed(() =>
    props.orders.filter((o) => {
        if (period.value && getYear(o.order_date) !== Number(period.value)) return false
        if (status.value && o.status !== status.value) return false
        return true
    })
)

function formatDate(dateString) {
    const date = new Date(dateString)
    const day = String(date.getDate()).padStart(2, '0')
    const month = String(date.getMonth() + 1).padStart(2, '0')
    return `${day}/${month}/${date.getFullYear()}`
}

function formatAmount(order) {
    const total =
        (parseFloat(order.subtotal) || 0) +
        (parseFloat(order.expedition) || 0) +
        (parseFloat(order.tax) || 0)
    const value = Number.isInteger(total) ? total : total.toFixed(2)
    return `${value} €`
}

function badgeClass(status) {
    switch (status) {
        case 'Terminée':
        case 'Livré':
            return 'history-badge-green'
        case 'Annulée':
            return 'history-badge-red'
        default:
            return 'history-badge-neutral'
    }
}
</script>
