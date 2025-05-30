<template>
    <section class="section-testimonial">
        <div class="container testimonial-header d-flex flex-column align-items-end gap-3">
            <h2 class="testimonial-title text-center w-100" id="temoignages">
                Ce que disent <span class="highlight">nos clients</span>
            </h2>
            <p class="testimonial-subtitle text-center w-100">
                Découvrez leurs expériences et la confiance qu'ils nous accordent.
            </p>
        </div>

        <div class="carousel-container">
            <div class="carousel-wrapper" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
                <div v-for="(group, index) in testimonialGroups" :key="index" class="carousel-slide">
                    <div class="row justify-content-center gap-4">
                        <div v-for="testimonial in group" :key="testimonial.name"
                            class="col-md-4 testimonial-card border rounded p-4 text-start">
                            <div class="d-flex align-items-center mb-3">
                                <img :src="testimonial.image" class="rounded-circle me-3" width="70" height="70"
                                    :alt="testimonial.name" />
                                <h5 class="mb-0 fw-bold title-card">{{ testimonial.name }}</h5>
                            </div>
                            <h6 class="fw-bold title-card">{{ testimonial.title }}</h6>
                            <p class="text-card small">{{ testimonial.text }}</p>
                            <div class="stars">★★★★★</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="testimonial-controls">
            <button class="btn btn-outline-secondary rounded-pill px-4 py-2 d-flex align-items-center gap-2"
                @click="previousSlide">
                <span class="arrow-prev"></span> Previous
            </button>

            <div class="testimonial-dots d-flex gap-3">
                <span v-for="(group, index) in testimonialGroups" :key="index" class="dot"
                    :class="{ active: index === currentSlide }" @click="goToSlide(index)"></span>
            </div>

            <button class="btn btn-outline-dark rounded-pill px-4 py-2 d-flex align-items-center gap-2"
                @click="nextSlide">
                Next <span class="arrow-next"></span>
            </button>
        </div>
    </section>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';

const currentSlide = ref(0);
let autoplayInterval = null;

const testimonials = [
    { name: "James Conway", image: "https://i.pravatar.cc/70?img=1", title: "Satisfait", text: "Service rapide et linge impeccable. Je recommande !" },
    { name: "W. Augustine", image: "https://i.pravatar.cc/70?img=8", title: "Parfait", text: "Livraison dans les temps. Très pratique au quotidien." },
    { name: "Jorge Mclaug", image: "https://i.pravatar.cc/70?img=5", title: "Efficace", text: "Une vraie solution pour les gens pressés comme moi." },
    { name: "Leila Hadad", image: "https://i.pravatar.cc/70?img=12", title: "Très pratique", text: "Plus besoin d'aller à la laverie, ça change la vie !" },
    { name: "Ahmed Nouri", image: "https://i.pravatar.cc/70?img=9", title: "Top", text: "Service client réactif, linge impeccable. Merci !" },
    { name: "Mila Forest", image: "https://i.pravatar.cc/70?img=3", title: "Super concept", text: "Rapide, propre, sécurisé. Je valide à 100%." },
    { name: "Carlos Vega", image: "https://i.pravatar.cc/70?img=7", title: "Nickel", text: "Repassage pro, livraison rapide. Rien à redire." },
    { name: "Emma Louvier", image: "https://i.pravatar.cc/70?img=11", title: "Conquise", text: "Je ne m'en passe plus. Application simple à utiliser." },
    { name: "Lucas Renard", image: "https://i.pravatar.cc/70?img=14", title: "Livré en 48h", text: "C'est devenu un réflexe pour moi chaque semaine." },
    { name: "Nina Kovac", image: "https://i.pravatar.cc/70?img=10", title: "Ecolo", text: "Super de savoir que les produits sont respectueux." },
    { name: "Yanis Belkacem", image: "https://i.pravatar.cc/70?img=18", title: "Propre & Repassé", text: "Un vrai service de pressing moderne et efficace." },
    { name: "Chloé Meyer", image: "https://i.pravatar.cc/70?img=4", title: "Ultra simple", text: "3 clics, et c'est réglé. Hyper intuitif et pratique." }
];

const testimonialGroups = computed(() => {
    const groups = [];
    for (let i = 0; i < testimonials.length; i += 3) {
        groups.push(testimonials.slice(i, i + 3));
    }
    return groups;
});

function nextSlide() {
    currentSlide.value = (currentSlide.value + 1) % testimonialGroups.value.length;
    resetAutoplay();
}

function previousSlide() {
    currentSlide.value = (currentSlide.value - 1 + testimonialGroups.value.length) % testimonialGroups.value.length;
    resetAutoplay();
}

function goToSlide(index) {
    currentSlide.value = index;
    resetAutoplay();
}

function startAutoplay() {
    autoplayInterval = setInterval(nextSlide, 5000);
}

function stopAutoplay() {
    if (autoplayInterval) {
        clearInterval(autoplayInterval);
    }
}

function resetAutoplay() {
    stopAutoplay();
    startAutoplay();
}

onMounted(() => {
    startAutoplay();
});

onBeforeUnmount(() => {
    stopAutoplay();
});
</script>
