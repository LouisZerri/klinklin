<template>
    <!-- Info pagination en haut -->
    <div class="pagination-info" v-if="showInfo">
        <span>{{ paginationInfo.start }}-{{ paginationInfo.end }} sur {{ totalItems }} {{ itemLabel }}</span>
    </div>

    <!-- Contrôles de pagination -->
    <div class="pagination-container" v-if="totalPages > 1">
        <nav class="pagination-nav">
            <button class="pagination-btn prev-btn" @click="goToPrevious" :disabled="currentPage === 1"
                :class="{ disabled: currentPage === 1 }">
                <i class="fas fa-chevron-left"></i>
                Précédent
            </button>

            <div class="pagination-numbers">
                <!-- Pagination simple pour moins de 8 pages -->
                <template v-if="totalPages <= 7">
                    <button v-for="page in totalPages" :key="page" class="pagination-number"
                        :class="{ active: page === currentPage }" @click="goToPage(page)">
                        {{ page }}
                    </button>
                </template>

                <!-- Pagination avec ellipses pour plus de 7 pages -->
                <template v-else>
                    <!-- Début : pages 1-5, ..., dernière -->
                    <template v-if="currentPage <= 4">
                        <button v-for="page in 5" :key="page" class="pagination-number"
                            :class="{ active: page === currentPage }" @click="goToPage(page)">
                            {{ page }}
                        </button>
                        <span class="pagination-ellipsis">...</span>
                        <button class="pagination-number" @click="goToPage(totalPages)">
                            {{ totalPages }}
                        </button>
                    </template>

                    <!-- Milieu : première, ..., current-1, current, current+1, ..., dernière -->
                    <template v-else-if="currentPage > 4 && currentPage < totalPages - 3">
                        <button class="pagination-number" @click="goToPage(1)">1</button>
                        <span class="pagination-ellipsis">...</span>
                        <button v-for="page in [currentPage - 1, currentPage, currentPage + 1]" :key="page"
                            class="pagination-number" :class="{ active: page === currentPage }" @click="goToPage(page)">
                            {{ page }}
                        </button>
                        <span class="pagination-ellipsis">...</span>
                        <button class="pagination-number" @click="goToPage(totalPages)">
                            {{ totalPages }}
                        </button>
                    </template>

                    <!-- Fin : première, ..., dernières 5 pages -->
                    <template v-else>
                        <button class="pagination-number" @click="goToPage(1)">1</button>
                        <span class="pagination-ellipsis">...</span>
                        <button v-for="page in getLastPages()" :key="page" class="pagination-number"
                            :class="{ active: page === currentPage }" @click="goToPage(page)">
                            {{ page }}
                        </button>
                    </template>
                </template>
            </div>

            <button class="pagination-btn next-btn" @click="goToNext" :disabled="currentPage === totalPages"
                :class="{ disabled: currentPage === totalPages }">
                Suivant
                <i class="fas fa-chevron-right"></i>
            </button>
        </nav>
    </div>
</template>

<script setup>
import { computed, defineEmits } from 'vue'

// Props
const props = defineProps({
    currentPage: {
        type: Number,
        required: true
    },
    totalItems: {
        type: Number,
        required: true
    },
    itemsPerPage: {
        type: Number,
        default: 6
    },
    itemLabel: {
        type: String,
        default: 'éléments'
    },
    showInfo: {
        type: Boolean,
        default: true
    },
    scrollTarget: {
        type: String,
        default: null // Sélecteur CSS pour l'élément vers lequel scroller
    }
})

// Events
const emit = defineEmits(['page-change'])

// Computed properties
const totalPages = computed(() => {
    return Math.ceil(props.totalItems / props.itemsPerPage)
})

const paginationInfo = computed(() => {
    const start = (props.currentPage - 1) * props.itemsPerPage + 1
    const end = Math.min(props.currentPage * props.itemsPerPage, props.totalItems)
    return { start, end }
})

// Methods
const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value && page !== props.currentPage) {
        emit('page-change', page)

        // Scroll vers l'élément cible si spécifié
        if (props.scrollTarget) {
            setTimeout(() => {
                const element = document.querySelector(props.scrollTarget)
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth', block: 'start' })
                }
            }, 50)
        }
    }
}

const goToPrevious = () => {
    if (props.currentPage > 1) {
        goToPage(props.currentPage - 1)
    }
}

const goToNext = () => {
    if (props.currentPage < totalPages.value) {
        goToPage(props.currentPage + 1)
    }
}

const getLastPages = () => {
    const lastPages = []
    for (let i = totalPages.value - 4; i <= totalPages.value; i++) {
        if (i > 1) {
            lastPages.push(i)
        }
    }
    return lastPages
}
</script>