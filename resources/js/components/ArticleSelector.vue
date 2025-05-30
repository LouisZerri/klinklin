<template>
    <div class="content-wrapper">
        <!-- Colonne principale avec articles -->
        <div class="main-column">
            <!-- Info pagination en haut -->
            <div class="pagination-info">
                <span>{{ paginationInfo.start }}-{{ paginationInfo.end }} sur {{ paginationInfo.total }} articles</span>
            </div>

            <div class="articles-grid">
                <div v-for="article in paginatedArticles" :key="article.id" class="article-card d-flex">
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

            <!-- Pagination -->
            <div class="pagination-container" v-if="totalPages > 1">
                <nav class="pagination-nav">
                    <button class="pagination-btn prev-btn" @click="prevPage" :disabled="currentPage === 1"
                        :class="{ disabled: currentPage === 1 }">
                        <i class="fas fa-chevron-left"></i>
                        Précédent
                    </button>

                    <div class="pagination-numbers">
                        <button v-for="page in Math.min(totalPages, 7)" :key="page" class="pagination-number"
                            :class="{ active: page === currentPage }" @click="goToPage(page)">
                            {{ page }}
                        </button>

                        <!-- Affichage avec ellipses pour beaucoup de pages -->
                        <template v-if="totalPages > 7">
                            <button v-if="currentPage <= 4" v-for="page in 5" :key="page" class="pagination-number"
                                :class="{ active: page === currentPage }" @click="goToPage(page)">
                                {{ page }}
                            </button>
                            <span v-if="currentPage <= 4" class="pagination-ellipsis">...</span>
                            <button v-if="currentPage <= 4" class="pagination-number" @click="goToPage(totalPages)">
                                {{ totalPages }}
                            </button>

                            <button v-if="currentPage > 4 && currentPage < totalPages - 3" class="pagination-number"
                                @click="goToPage(1)">
                                1
                            </button>
                            <span v-if="currentPage > 4 && currentPage < totalPages - 3"
                                class="pagination-ellipsis">...</span>
                            <button v-if="currentPage > 4 && currentPage < totalPages - 3"
                                v-for="page in [currentPage - 1, currentPage, currentPage + 1]" :key="page"
                                class="pagination-number" :class="{ active: page === currentPage }"
                                @click="goToPage(page)">
                                {{ page }}
                            </button>
                            <span v-if="currentPage > 4 && currentPage < totalPages - 3"
                                class="pagination-ellipsis">...</span>
                            <button v-if="currentPage > 4 && currentPage < totalPages - 3" class="pagination-number"
                                @click="goToPage(totalPages)">
                                {{ totalPages }}
                            </button>

                            <button v-if="currentPage >= totalPages - 3" class="pagination-number" @click="goToPage(1)">
                                1
                            </button>
                            <span v-if="currentPage >= totalPages - 3" class="pagination-ellipsis">...</span>
                            <button v-if="currentPage >= totalPages - 3"
                                v-for="page in [totalPages - 4, totalPages - 3, totalPages - 2, totalPages - 1, totalPages].filter(p => p > 1)"
                                :key="page" class="pagination-number" :class="{ active: page === currentPage }"
                                @click="goToPage(page)">
                                {{ page }}
                            </button>
                        </template>
                    </div>

                    <button class="pagination-btn next-btn" @click="nextPage" :disabled="currentPage === totalPages"
                        :class="{ disabled: currentPage === totalPages }">
                        Suivant
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </nav>
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
                        <input type="checkbox" id="bebe" v-model="filters.usages" value="Bébé" />
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
import { ref, reactive, computed, onMounted, watch } from 'vue'

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
    maxPrice: 100,
    types: [],
    usages: [],
    weights: []
})
const currentPage = ref(1)
const itemsPerPage = 6

const totalPages = computed(() => {
    return Math.ceil(filteredArticles.value.length / itemsPerPage)
})

const paginatedArticles = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage
    const end = start + itemsPerPage
    return filteredArticles.value.slice(start, end)
})

const paginationInfo = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage + 1
    const end = Math.min(currentPage.value * itemsPerPage, filteredArticles.value.length)
    return {
        start,
        end,
        total: filteredArticles.value.length
    }
})

// Méthodes de pagination
const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page
        // Scroll vers le haut de la grille d'articles
        const articlesGrid = document.querySelector('.articles-grid')
        if (articlesGrid) {
            articlesGrid.scrollIntoView({ behavior: 'smooth', block: 'start' })
        }
    }
}

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        goToPage(currentPage.value + 1)
    }
}

const prevPage = () => {
    if (currentPage.value > 1) {
        goToPage(currentPage.value - 1)
    }
}

watch(
    () => [filters.maxPrice, filters.types, filters.usages, filters.weights],
    () => {
        currentPage.value = 1
    },
    { deep: true }
)


// Méthodes utilitaires
const normalize = (str) => {
    return str
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
}

const getWeightCategory = (weightRanges) => {
    if (!weightRanges || typeof weightRanges !== 'object') return 'leger'

    // Calculer le poids moyen en prenant la première range disponible
    const firstLabel = Object.keys(weightRanges)[0]
    if (!firstLabel) return 'leger'

    const range = weightRanges[firstLabel]
    if (!Array.isArray(range) || range.length < 2) return 'leger'

    const avgWeight = (range[0] + range[1]) / 2

    if (avgWeight < 0.4) return 'leger'
    if (avgWeight <= 0.8) return 'moyen'
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
            const selectedTypes = filters.types.map(t => {
                // Conversion des valeurs du filtre vers les valeurs de la base
                if (t === 'vetements') return normalize('Vêtements')
                if (t === 'linge-maison') return normalize('Linge de maison')
                if (t === 'delicat') return normalize('Délicat')
                return normalize(t)
            })
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
            const weightCategory = getWeightCategory(article.weight_ranges)
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
    // Calculer le prix maximum des articles
    const maxPrice = Math.max(...props.articles.map(article =>
        parseFloat(article.unit_price) || 0
    ))

    // Mettre à jour le filtre avec le prix max + une marge
    filters.maxPrice = Math.ceil(maxPrice + 10)

    // Mettre à jour aussi l'attribut max du slider
    const priceSlider = document.querySelector('.price-slider')
    if (priceSlider) {
        priceSlider.setAttribute('max', filters.maxPrice)
    }

    // Initialisation des poids et quantités pour chaque article
    props.articles.forEach(article => {
        selectedWeights.value[article.id] = getFirstWeightRange(article)
        quantities.value[article.id] = 0
    })
})
</script>