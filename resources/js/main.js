import { createApp } from 'vue'
import TestimonialCarousel from './components/TestimonialCarousel.vue'
import BlogCarousel from './components/BlogCarousel.vue'
import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/css/intlTelInput.css";
import ProgressBar from './components/ProgressBar.vue';
import ArticleSelector from './components/ArticleSelector.vue';
import BookingSelector from './components/BookingSelector.vue';
import StripeCheckout from './components/StripeCheckout.vue';
import Confettis from './components/Confettis.vue';
import Order from './components/Order.vue';
import Invoice from './components/Invoice.vue';


// INTEGRATION DE VUEJS 
const app = createApp({})

app.component('TestimonialCarousel', TestimonialCarousel)
app.component('BlogCarousel', BlogCarousel)
app.component('ProgressBar', ProgressBar)
app.component('ArticleSelector', ArticleSelector)
app.component('BookingSelector', BookingSelector)
app.component('StripeCheckout', StripeCheckout)
app.component('Confettis', Confettis);
app.component('Order', Order);
app.component('Invoice', Invoice);


app.mount('#app')


// TOAST CONTAINER
export function showToast(message, type = "success") {
    const toastContainer = document.getElementById("toast-container");

    const toast = document.createElement("div");
    toast.className = `toast toast-${type}`;

    const progress = document.createElement("div");
    progress.className = "toast-progress";

    toast.innerHTML = `
        <span>${message}</span>
        <button class="close-btn" onclick="this.parentElement.remove()">×</button>
    `;
    toast.appendChild(progress);
    toastContainer.appendChild(toast);

    // Déclenche l'animation de la progress bar
    setTimeout(() => {
        toast.classList.add("show");
    }, 100);

    // Supprime après 5s
    setTimeout(() => {
        toast.remove();
    }, 5000);
}

// INTERACTION BASIQUE DU DOM
document.addEventListener("DOMContentLoaded", () => {

    // Initialisation de l'input téléphone international
    const input = document.querySelector("#phone");

    if (input) {
        const iti = intlTelInput(input, {
            initialCountry: "fr",
            preferredCountries: ["fr", "cg", "ma", "ci", "sn"],
            separateDialCode: true,
            nationalMode: false,
            autoPlaceholder: "aggressive",
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
            responsiveDropdown: true,
        });

        // Événement lors du changement de pays
        input.addEventListener("countrychange", () => {
            console.log("Pays sélectionné :", iti.getSelectedCountryData());
        });

        // Validation du numéro lors de la perte de focus
        input.addEventListener("blur", () => {
            if (input.value.trim()) {
                if (!iti.isValidNumber()) {
                    // Ajouter une classe d'erreur ou un message
                    input.classList.add("error");
                } else {
                    input.classList.remove("error");
                }
            }
        });

        // Gestion des bordures de l'input
        input.parentElement.classList.add("iti-enabled");
    }

    // FAQ sections
    document.querySelectorAll(".faq-question").forEach((btn) => {
        btn.addEventListener("click", () => {
            const isActive = btn.classList.contains("active");
            document
                .querySelectorAll(".faq-question")
                .forEach((q) => q.classList.remove("active"));
            document
                .querySelectorAll(".faq-answer")
                .forEach((a) => (a.style.display = "none"));

            if (!isActive) {
                btn.classList.add("active");
                btn.nextElementSibling.style.display = "block";
            }
        });
    });

    // Gestion responsive du menu mobile
    const mobileMenuToggle = document.querySelector(".mobile-menu-toggle");
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener("click", () => {
            document.querySelector(".nav-menu").classList.toggle("active");
        });
    }

    // Gestion des toasts
    const flash = document.getElementById("toast-data");

    // Vérifie si l'utilisateur vient de revenir en arrière
    const isBackNavigation =
        performance.getEntriesByType("navigation")[0]?.type === "back_forward";

    // N'affiche les toasts que si ce n'est pas un retour en arrière
    if (flash && !isBackNavigation) {
        const success = flash.dataset.success;
        const status = flash.dataset.status;
        const errors = JSON.parse(flash.dataset.errors || "[]");

        if (success) showToast(success, "success");
        if (status) showToast(status, "success");
        errors.forEach((msg) => showToast(msg, "error"));
    }

    // Dans tous les cas, on supprime la div pour éviter des problèmes
    if (flash) {
        flash.remove();
    }
});