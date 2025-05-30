<template>
    <div class="progress-container">
        <div class="progress-bar"></div>
        <div class="progress-fill" :style="progressFillStyle"></div>

        <div class="stepper-container">
            <div v-for="(step, index) in steps" :key="index" class="stepper"
                :class="{ 'active': index + 1 <= currentStep, 'current': index + 1 === currentStep }">
                <div class="stepper-circle"></div>
                <div class="stepper-title">{{ step }}</div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

// Définir les étapes par défaut
const steps = [
    'Informations de collecte',
    'Articles',
    'Récapitulatifs',
    'Paiement'
];

// État local
const currentStep = ref(1);
const isMobile = ref(window.innerWidth <= 768);

// Style calculé pour la barre de progression
const progressFillStyle = computed(() => {
    // Mode mobile (vertical)
    if (isMobile.value) {
        const mobileHeights = {
            1: '60px',
            2: '160px',
            3: '280px',
            4: '450px'
        };

        return {
            width: '12px',
            height: mobileHeights[currentStep.value] || '60px'
        };
    }
    // Mode desktop (horizontal)
    else {
        const desktopWidths = {
            1: '25%',
            2: '50%',
            3: '75%',
            4: '100%'
        };

        return {
            height: '18px',
            width: desktopWidths[currentStep.value] || '25%'
        };
    }
});

// Mettre à jour l'état mobile/desktop lors du redimensionnement
function handleResize() {
    isMobile.value = window.innerWidth <= 768;
}

// Fonction pour déterminer l'étape actuelle en fonction de l'URL
function updateStepFromUrl() {
    const currentUrl = window.location.pathname;

    if (currentUrl.includes('paiement')) {
        currentStep.value = 4;
    } else if (currentUrl.includes('recap')) {
        currentStep.value = 3;
    } else if (currentUrl.includes('articles')) {
        currentStep.value = 2;
    } else if (currentUrl.includes('collecte')) {
        currentStep.value = 1;
    }
}

// Méthode pour mettre à jour l'étape manuellement (exposée pour usage externe)
function updateProgress(step) {
    currentStep.value = step;
}

// Exposer les méthodes
defineExpose({
    updateProgress
});

// Cycle de vie du composant
onMounted(() => {
    // Initialisation de la taille
    handleResize();

    // Détection des changements de taille d'écran
    window.addEventListener('resize', handleResize);

    // Déterminer l'étape initiale en fonction de l'URL
    updateStepFromUrl();

    // Écouter les changements d'URL (pour les SPA qui utilisent history.pushState)
    window.addEventListener('popstate', updateStepFromUrl);
});

onUnmounted(() => {
    // Nettoyage des écouteurs d'événements
    window.removeEventListener('resize', handleResize);
    window.removeEventListener('popstate', updateStepFromUrl);
});
</script>
