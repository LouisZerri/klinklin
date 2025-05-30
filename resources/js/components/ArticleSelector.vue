<template>
    <div class="content-wrapper">
        <!-- Colonne principale avec articles -->
        <div class="main-column">
            <div class="articles-grid">
                <div v-for="article in filteredArticles" :key="article.id" class="article-card d-flex">
                    <img :src="article.image_url" class="article-image" :alt="article.name" />
                    <div class="article-details">
                        <div class="article-info">
                            <div class="article-name">{{ article.name }}</div>
                            <div class="article-price">{{ Math.floor(parseFloat(article.unit_price) || 0) }} €</div>
                            <div class="select-wrapper">
                                <select v-model="selectedWeights[article.id]" class="article-weight"
                                    @change="updateArticleWeight(article.id)">
                                    <option v-for="(range, label) in article.weight_ranges" :key="label"
                                        :value="`${range[0]}-${range[1]}`">
                                        {{ capitalize(label) }} ({{ range[0] }} – {{ range[1] }} kg)
                                    </option>
                                </select>
                                <i class="fa-solid fa-chevron-down select-icon"></i>
                            </div>
                        </div>

                        <div class="input-group quantity-input-group">
                            <button class="btn" type="button" @click="decrementQuantity(article.id)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="form-control text-center" :value="quantities[article.id] || 0"
                                min="0" max="99" readonly />
                            <button class="btn" type="button" @click="incrementQuantity(article.id)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions et résumé -->
            <div class="articles-summary-actions">
                <div class="total-price-row">
                    <span>Prix estimé :</span>
                    <span id="total-price">{{ totalPrice.toFixed(2) }}€</span>
                </div>
                <form @submit="handleSubmit" method="POST">
                    <input type="hidden" name="_token" :value="csrfToken">
                    <input type="hidden" name="articles_data" :value="articlesDataJson">
                    <div class="form-buttons">
                        <button type="submit" class="btn btn-purple-dashboard">
                            Poursuivre ma commande
                        </button>
                        <a :href="cancelUrl" class="btn btn-red">Retour</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Colonne des filtres -->
        <div class="filters-container">
            <!-- Filtre prix -->
            <div class="filter-section">
                <div class="filter-title">
                    Prix <span style="margin-left: auto">€0-{{ filters.maxPrice }}</span>
                </div>
                <input type="range" class="price-slider" min="0" max="50" v-model="filters.maxPrice" />
            </div>

            <!-- Filtre par type -->
            <div class="filter-section">
                <div class="filter-title">
                    Par type <i class="fas fa-chevron-down"></i>
                </div>
                <div class="filter-options">
                    <div class="filter-option">
                        <input type="checkbox" id="vetements" v-model="filters.types" value="vetements" />
                        <label for="vetements">Vêtements</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="linge-maison" v-model="filters.types" value="linge-maison" />
                        <label for="linge-maison">Linge de maison</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="delicat" v-model="filters.types" value="delicat" />
                        <label for="delicat">Délicat</label>
                    </div>
                </div>
            </div>

            <!-- Filtre par usage -->
            <div class="filter-section">
                <div class="filter-title">
                    Par usage <i class="fas fa-chevron-down"></i>
                </div>
                <div class="filter-options">
                    <div class="filter-option">
                        <input type="checkbox" id="homme" v-model="filters.usages" value="Homme" />
                        <label for="homme">Homme</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="femme" v-model="filters.usages" value="Femme" />
                        <label for="femme">Femme</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="enfant" v-model="filters.usages" value="Enfant" />
                        <label for="enfant">Enfant</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="bebe" v-model="filters.usages" value="Bebe" />
                        <label for="bebe">Bébé</label>
                    </div>
                </div>
            </div>

            <!-- Filtre par poids -->
            <div class="filter-section">
                <div class="filter-title">
                    Par poids estimé <i class="fas fa-chevron-down"></i>
                </div>
                <div class="filter-options">
                    <div class="filter-option">
                        <input type="checkbox" id="leger" v-model="filters.weights" value="leger" />
                        <label for="leger">Léger (- 0.4 kg)</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="moyen" v-model="filters.weights" value="moyen" />
                        <label for="moyen">Moyen (0.4–0.8 kg)</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="lourd" v-model="filters.weights" value="lourd" />
                        <label for="lourd">Lourd (+ 0.8 kg)</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'

// Props
const props = defineProps({
    articles: {
        type: Array,
        required: true
    },
    postArticlesUrl: {
        type: String,
        required: true
    },
    cancelUrl: {
        type: String,
        required: true
    },
    csrfToken: {
        type: String,
        required: true
    }
})

// State réactif
const quantities = ref({})
const selectedWeights = ref({})
const filters = reactive({
    maxPrice: 30,
    types: [],
    usages: [],
    weights: []
})

// Méthodes utilitaires
const normalize = (str) => {
    return str
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
}

const getWeightCategory = (baseWeight) => {
    if (baseWeight < 0.4) return 'leger'
    if (baseWeight <= 0.8) return 'moyen'
    return 'lourd'
}

const getFirstWeightRange = (article) => {
    const firstLabel = Object.keys(article.weight_ranges)[0]
    const range = article.weight_ranges[firstLabel]
    return `${range[0]}-${range[1]}`
}

const capitalize = (str) => {
    return str.charAt(0).toUpperCase() + str.slice(1)
}


// Computed properties
const filteredArticles = computed(() => {
    return props.articles.filter(article => {
        const unitPrice = parseFloat(article.unit_price) || 0

        // Filtre prix
        if (unitPrice > filters.maxPrice) return false

        // Filtre type
        if (filters.types.length > 0) {
            const normalizedType = normalize(article.type || '')
            const selectedTypes = filters.types.map(t => normalize(t))
            if (!selectedTypes.includes(normalizedType)) return false
        }

        // Filtre usage
        if (filters.usages.length > 0) {
            const articleUsages = (article.usage || []).map(u => normalize(u))
            const selectedUsages = filters.usages.map(u => normalize(u))

            const hasAtLeastOne = articleUsages.some(u => selectedUsages.includes(u))
            if (!hasAtLeastOne) return false
        }

        // Filtre poids
        if (filters.weights.length > 0) {
            const weightCategory = getWeightCategory(article.base_weight)
            const selectedWeights = filters.weights.map(w => normalize(w))
            if (!selectedWeights.includes(normalize(weightCategory))) return false
        }

        return true
    })
})

const totalPrice = computed(() => {
    let total = 0

    for (const [articleId, qty] of Object.entries(quantities.value)) {
        if (qty <= 0) continue

        const article = props.articles.find(a => a.id == articleId)
        if (!article) continue

        const unitPrice = parseFloat(article.unit_price) || 0
        total += unitPrice * qty
    }

    return total
})


const articlesDataJson = computed(() => {
    const data = []

    for (const [articleId, qty] of Object.entries(quantities.value)) {
        if (qty <= 0) continue

        const article = props.articles.find(a => a.id == articleId)
        if (!article) continue

        const weightRange = selectedWeights.value[article.id] || getFirstWeightRange(article)
        const [min, max] = weightRange.split('-').map(parseFloat)
        const avgWeight = ((min + max) / 2) * qty
        const unitPrice = parseFloat(article.unit_price) || 0

        data.push({
            article_id: article.id,
            name: article.name,
            quantity: qty,
            unit_price: unitPrice.toFixed(2),
            avg_weight: avgWeight.toFixed(3),
            total_price: (qty * unitPrice).toFixed(2)
        })
    }

    return JSON.stringify(data)
})


// Méthodes pour gérer les quantités
const incrementQuantity = (articleId) => {
    const currentQty = quantities.value[articleId] || 0
    if (currentQty < 99) {
        quantities.value[articleId] = currentQty + 1
    }
}

const decrementQuantity = (articleId) => {
    const currentQty = quantities.value[articleId] || 0
    if (currentQty > 0) {
        quantities.value[articleId] = currentQty - 1
    }
}

const updateArticleWeight = (articleId) => {
    console.log(`Poids mis à jour pour l'article ${articleId}`)
}

// Gestion de la soumission du formulaire
const handleSubmit = (event) => {
    const data = JSON.parse(articlesDataJson.value)

    if (data.length === 0) {
        event.preventDefault()
        return
    }

    const total = data.reduce((sum, item) => sum + parseFloat(item.total_price), 0)
    if (total <= 0) {
        event.preventDefault()
        return
    }
}

// Initialisation au montage du composant
onMounted(() => {
    props.articles.forEach(article => {
        selectedWeights.value[article.id] = getFirstWeightRange(article)
        quantities.value[article.id] = 0
    })
})
</script>