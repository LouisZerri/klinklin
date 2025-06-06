<template>
    <form id="payment-form" @submit.prevent="handleSubmit">
        <div id="payment-element">
            <!--Stripe.js injects the Payment Element-->
        </div>
        <button id="submit">
            <div class="spinner hidden" id="spinner"></div>
            <span id="button-text">Régler {{ total }} €</span>
        </button>
        <div id="payment-message" class="hidden"></div>
    </form>
</template>

<script setup>
import { onMounted } from 'vue';
import useStripe from '../composables/useStripe';

defineProps({
  total: Number
})


const {
    initialize,
    checkStatus,
    handleSubmit
} = useStripe();


onMounted(async () => {
    await initialize();
    await checkStatus();
})

window.dispatchEvent(new CustomEvent("cart-updated", {
    detail: { total: 0 }
}));

</script>

<style scoped>

* {
    box-sizing: border-box;
    font-family: "Montserrat", sans-serif;
}

#payment-form {
    width: 80vh;
    min-width: 500px;
    max-width: 100%;
    padding: 32px 20px;
}

form {
    align-self: center;
    box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
        0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
    flex: 1;
    border-radius: 12px;
}

.hidden {
    display: none;
}

#payment-message {
    color: rgb(105, 115, 134);
    font-size: 16px;
    line-height: 20px;
    padding-top: 12px;
    text-align: center;
}

#payment-element {
    margin-bottom: 24px;
}

/* Buttons and links */
button {
    background-color: #461871;
    color: #FFFBFA;
    border-radius: 16px;
    border: 0;
    padding: 12px 16px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: block;
    transition: all 0.2s ease;
    box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
    width: 100%;
}

button:hover {
    filter: contrast(115%);
    background-color: #3F1666;
}

button:disabled {
    opacity: 0.5;
    cursor: default;
}

/* spinner/processing state, errors */
.spinner,
.spinner:before,
.spinner:after {
    border-radius: 50%;
}

.spinner {
    color: #ffffff;
    font-size: 22px;
    text-indent: -99999px;
    margin: 0px auto;
    position: relative;
    width: 20px;
    height: 20px;
    box-shadow: inset 0 0 0 2px;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
}

.spinner:before,
.spinner:after {
    position: absolute;
    content: "";
}

.spinner:before {
    width: 10.4px;
    height: 20.4px;
    background: #461871;
    border-radius: 20.4px 0 0 20.4px;
    top: -0.2px;
    left: -0.2px;
    -webkit-transform-origin: 10.4px 10.2px;
    transform-origin: 10.4px 10.2px;
    -webkit-animation: loading 2s infinite ease 1.5s;
    animation: loading 2s infinite ease 1.5s;
}

.spinner:after {
    width: 10.4px;
    height: 10.2px;
    background: #461871;
    border-radius: 0 10.2px 10.2px 0;
    top: -0.1px;
    left: 10.2px;
    -webkit-transform-origin: 0px 10.2px;
    transform-origin: 0px 10.2px;
    -webkit-animation: loading 2s infinite ease;
    animation: loading 2s infinite ease;
}

/* Payment status page */
#payment-status {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    row-gap: 30px;
    width: 30vw;
    min-width: 500px;
    min-height: 380px;
    align-self: center;
    box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
        0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
    border-radius: 7px;
    padding: 40px;
    opacity: 0;
    animation: fadeInAnimation 1s ease forwards;
}

#status-icon {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 40px;
    width: 40px;
    border-radius: 50%;
}

h2 {
    margin: 0;
    color: #30313D;
    text-align: center;
}

a {
    text-decoration: none;
    font-size: 16px;
    font-weight: 600;
    font-family: Arial, sans-serif;
    display: block;
}

a:hover {
    filter: contrast(120%);
}

#details-table {
    overflow-x: auto;
    width: 100%;
}

table {
    width: 100%;
    font-size: 14px;
    border-collapse: collapse;
}

table tbody tr:first-child td {
    border-top: 1px solid #E6E6E6;
    /* Top border */
    padding-top: 10px;
}

table tbody tr:last-child td {
    border-bottom: 1px solid #E6E6E6;
    /* Bottom border */
}

td {
    padding-bottom: 10px;
}

.p-tab {
    background-color: #461871 !important;
}

.TableContent {
    text-align: right;
    color: #6D6E78;
}

.TableLabel {
    font-weight: 600;
    color: #30313D;
}

#view-details {
    color: #461871;
}

#retry-button {
    text-align: center;
    background: #461871;
    color: #FFFBFA;
    border-radius: 16px;
    border: 0;
    padding: 12px 16px;
    transition: all 0.2s ease;
    box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
    width: 100%;
}

@-webkit-keyframes loading {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

@keyframes loading {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

@keyframes fadeInAnimation {
    to {
        opacity: 1;
    }
}

@media (max-width: 780px) {
    #payment-form {
        margin-bottom: 80px;
    }
}

@media (max-width: 550px) {
    /* Réduire la taille des inputs */
    .input-floating-wrapper .booking-input {
        font-size: 14px;  
        padding: 12px 10px;
        height: 48px; 
    }
    /* Réduire la largeur des inputs */
    .input-floating-wrapper {
        width: 100%; 
    }

    /* Réduit la largeur du formulaire */
    form {
        width: 90vw;
        max-width: 400px;
        padding: 20px 16px;
        box-shadow: none;
    }

    /* Mettre les éléments en colonne, y compris le bouton */
    #payment-form {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }

    /* Mettre le bouton en haut */
    button {
        padding: 10px 20px;
        font-size: 14px;
        width: auto;
        max-width: 250px;
        margin: 0 auto;    
    }

    /* Réduit la taille du spinner */
    .spinner {
        width: 16px;
        height: 16px;
    }

    /* Ajuster l'espace sous les champs de paiement */
    #payment-element {
        margin-bottom: 16px;
    }

    /* Ajuster le message de statut */
    #payment-message {
        font-size: 14px;
    }
}

</style>