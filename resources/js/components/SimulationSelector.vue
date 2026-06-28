<template>
    <div class="simulation-wrapper">
        <!-- Grille d'articles -->
        <div class="simulation-articles">
            <div class="articles-grid">
                <div v-for="article in articles" :key="article.id" class="article-card d-flex">
                    <img v-if="article.image_url" :src="article.image_url" class="article-image" :alt="article.name" />
                    <div v-else class="article-image article-image-placeholder">
                        <i class="fa-solid fa-shirt"></i>
                    </div>

                    <div class="article-details">
                        <div class="article-info">
                            <div class="article-name">{{ article.name }}</div>
                            <div class="article-price">{{ formatPrice(article.unit_price) }} € / pièce</div>
                            <div class="select-wrapper" v-if="hasWeightRanges(article)">
                                <select v-model="selectedWeights[article.id]" class="article-weight">
                                    <option v-for="(range, label) in article.weight_ranges" :key="label"
                                        :value="`${range[0]}-${range[1]}`">
                                        {{ capitalize(label) }} ({{ range[0] }} – {{ range[1] }} kg)
                                    </option>
                                </select>
                                <i class="fa-solid fa-chevron-down select-icon"></i>
                            </div>
                        </div>

                        <div class="input-group quantity-input-group">
                            <button class="btn" type="button" @click="decrement(article.id)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="form-control text-center"
                                :value="quantities[article.id] || 0" min="0" max="99" readonly />
                            <button class="btn" type="button" @click="increment(article.id)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Récapitulatif de l'estimation -->
        <aside class="simulation-summary">
            <h3 class="simulation-summary-title">Votre estimation</h3>

            <div v-if="selectedCount === 0" class="simulation-empty">
                Ajoutez des articles pour estimer le tarif de votre collecte.
            </div>

            <template v-else>
                <ul class="simulation-lines">
                    <li v-for="line in summaryLines" :key="line.id">
                        <span>{{ line.quantity }} × {{ line.name }}</span>
                        <span>{{ formatPrice(line.total) }} €</span>
                    </li>
                </ul>

                <div class="simulation-row">
                    <span>Sous-total</span>
                    <span>{{ formatPrice(subtotal) }} €</span>
                </div>
                <div class="simulation-row">
                    <span>Livraison</span>
                    <span>{{ formatPrice(deliveryFee) }} €</span>
                </div>
                <div class="simulation-row">
                    <span>TVA</span>
                    <span>{{ formatPrice(taxFee) }} €</span>
                </div>
                <div class="simulation-row simulation-total">
                    <span>Total estimé</span>
                    <span>{{ formatPrice(total) }} €</span>
                </div>

                <p class="simulation-weight">
                    Poids estimé : <strong>{{ totalWeight.toFixed(2) }} kg</strong>
                </p>
            </template>

            <a :href="ctaUrl" class="btn btn-purple w-100 mt-3">{{ ctaLabel }}</a>
            <p class="simulation-note">
                Estimation indicative. Le tarif définitif est confirmé lors de la collecte.
            </p>
        </aside>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

const props = defineProps({
    articles: { type: Array, required: true },
    ctaUrl: { type: String, required: true },
    ctaLabel: { type: String, default: 'Planifier ma collecte' },
    deliveryFee: { type: Number, default: 10 },
    taxFee: { type: Number, default: 5 },
})

const quantities = ref({})
const selectedWeights = ref({})

const hasWeightRanges = (article) =>
    article.weight_ranges && typeof article.weight_ranges === 'object' && Object.keys(article.weight_ranges).length > 0

const getFirstWeightRange = (article) => {
    if (!hasWeightRanges(article)) return '0-0'
    const firstLabel = Object.keys(article.weight_ranges)[0]
    const range = article.weight_ranges[firstLabel]
    return `${range[0]}-${range[1]}`
}

const capitalize = (str) => str.charAt(0).toUpperCase() + str.slice(1)
const formatPrice = (value) => (parseFloat(value) || 0).toFixed(2).replace('.', ',')

const increment = (id) => {
    const current = quantities.value[id] || 0
    if (current < 99) quantities.value[id] = current + 1
}

const decrement = (id) => {
    const current = quantities.value[id] || 0
    if (current > 0) quantities.value[id] = current - 1
}

const selectedCount = computed(() =>
    Object.values(quantities.value).reduce((sum, qty) => sum + (qty > 0 ? 1 : 0), 0)
)

const summaryLines = computed(() => {
    const lines = []
    for (const [id, qty] of Object.entries(quantities.value)) {
        if (qty <= 0) continue
        const article = props.articles.find(a => a.id == id)
        if (!article) continue
        const unitPrice = parseFloat(article.unit_price) || 0
        lines.push({ id, name: article.name, quantity: qty, total: unitPrice * qty })
    }
    return lines
})

const subtotal = computed(() => summaryLines.value.reduce((sum, line) => sum + line.total, 0))

const totalWeight = computed(() => {
    let weight = 0
    for (const [id, qty] of Object.entries(quantities.value)) {
        if (qty <= 0) continue
        const article = props.articles.find(a => a.id == id)
        if (!article) continue
        const range = selectedWeights.value[id] || getFirstWeightRange(article)
        const [min, max] = range.split('-').map(parseFloat)
        weight += ((min + max) / 2) * qty
    }
    return weight
})

const total = computed(() =>
    selectedCount.value > 0 ? subtotal.value + props.deliveryFee + props.taxFee : 0
)

onMounted(() => {
    props.articles.forEach(article => {
        quantities.value[article.id] = 0
        selectedWeights.value[article.id] = getFirstWeightRange(article)
    })
})
</script>
