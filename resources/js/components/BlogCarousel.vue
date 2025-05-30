<template>
    <section class="blog-section container py-5">
        <div class="blog-header text-center mb-5">
            <h2 class="blog-title" id="blog">
                <span class="highlight">Articles & Conseils</span> pour un
                linge impeccable
            </h2>
            <p class="blog-subtitle">
                Inspirez-vous de nos astuces pour prendre soin de vos
                vêtements au quotidien.
            </p>
        </div>

        <div class="carousel-container">
            <div class="carousel-wrapper" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
                <div v-for="(group, index) in blogPostGroups" :key="index" class="carousel-slide">
                    <div class="d-flex flex-column flex-lg-row gap-4 justify-content-center align-items-end">
                        <div v-for="post in group" :key="post.title" class="blog-card position-relative">
                            <div class="blog-img">
                                <img :src="post.image" :alt="post.title" />
                            </div>
                            <div class="blog-card-body">
                                <span class="blog-tag">{{ post.tag }}</span>
                                <h3 class="blog-card-title">{{ post.title }}</h3>
                                <p class="blog-card-text">{{ post.text }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="blog-controls">
            <button class="btn btn-outline-secondary rounded-pill px-4 py-2 d-flex align-items-center gap-2"
                @click="previousSlide">
                <span class="arrow-prev"></span> Previous
            </button>

            <div class="blog-dots d-flex gap-3">
                <span v-for="(group, index) in blogPostGroups" :key="index" class="dot"
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

const erreurImg = '/images/erreurs.png';
const lavageImg = '/images/lavage.png';

const blogPosts = [
    {
        title: "5 erreurs à éviter quand vous lavez vos vêtements",
        tag: "Nouveau",
        text: "Apprenez à ne plus abîmer vos habits : surdosage de lessive, tri des couleurs, cycles trop agressifs…",
        image: erreurImg,
    },
    {
        title: "Lavage écoresponsable : comment KLINKLIN réduit son impact environnemental",
        tag: "Nouveau",
        text: "Découvrez nos engagements pour un linge propre grâce à des produits respectueux, une eau maîtrisée...",
        image: lavageImg,
    },
    {
        title: "Comment détacher un vêtement efficacement ?",
        tag: "Conseil",
        text: "Méthodes naturelles et efficaces pour enlever les taches sans abîmer vos tissus préférés.",
        image: "https://picsum.photos/600/300",
    },
    {
        title: "Choisir la bonne lessive pour votre linge",
        tag: "Astuce",
        text: "Lessive bio, liquide ou en poudre ? Voici comment choisir celle qui respecte vos textiles et l'environnement.",
        image: "https://picsum.photos/600/300",
    },
    {
        title: "Comment plier vos vêtements comme un pro",
        tag: "Astuces",
        text: "Découvrez des techniques simples pour optimiser votre rangement et éviter les plis.",
        image: "https://picsum.photos/600/300",
    },
    {
        title: "Routine linge : 5 étapes pour ne plus rien oublier",
        tag: "Organisation",
        text: "Une checklist pour ne plus louper aucune étape du lavage au rangement.",
        image: "https://picsum.photos/600/300",
    },
    {
        title: "Faut-il vraiment trier les couleurs ?",
        tag: "Mythe ou vérité",
        text: "On vous explique pourquoi ce réflexe évite bien des catastrophes (et du rose involontaire).",
        image: "https://picsum.photos/600/300",
    },
    {
        title: "Séchage à l'air libre vs. machine : le match",
        tag: "Comparatif",
        text: "Impact écologique, rapidité, tenue des tissus : on compare pour vous les deux méthodes.",
        image: "https://picsum.photos/600/300",
    }
];

const blogPostGroups = computed(() => {
    const groups = [];
    for (let i = 0; i < blogPosts.length; i += 2) {
        groups.push(blogPosts.slice(i, i + 2));
    }
    return groups;
});

function nextSlide() {
    currentSlide.value = (currentSlide.value + 1) % blogPostGroups.value.length;
    resetAutoplay();
}

function previousSlide() {
    currentSlide.value = (currentSlide.value - 1 + blogPostGroups.value.length) % blogPostGroups.value.length;
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
