import { ref } from "vue";
import axios from "axios";
import { loadStripe } from "@stripe/stripe-js";

const stripe = ref(null);
const elements = ref(null);

export default function useStripe() {
    const initialize = async () => {
        stripe.value = await loadStripe(
            import.meta.env.VITE_STRIPE_TEST_PUBLIC_KEY
        );

        if (!stripe.value) {
            console.error("Stripe non initialisé");
            return;
        }

        const clientSecret = await axios
            .post("/collecte/paiement")
            .then((r) => r.data.clientSecret)
            .catch((err) => {
                console.error(
                    "Erreur lors de la récupération du clientSecret",
                    err
                );
                return null;
            });

        if (!clientSecret) return;

        elements.value = stripe.value.elements({
            clientSecret,
            appearance: {
                theme: "flat",
                variables: {
                    colorPrimary: "#461871",
                    fontFamily: "Montserrat, sans-serif",
                    fontSizeBase: "16px",
                    colorText: "#32325d",
                },
            },
        });

        const paymentElement = elements.value.create("payment");
        paymentElement.mount("#payment-element");
    };

    const handleSubmit = async (event) => {
        event.preventDefault();

        const spinner = document.getElementById("spinner");
        const buttonText = document.getElementById("button-text");

        spinner?.classList.remove("hidden");
        buttonText.textContent = "Traitement en cours...";

        const { error } = await stripe.value.confirmPayment({
            elements: elements.value,
            confirmParams: {
                return_url: window.location.origin + "/thankyou",
            },
        });

        spinner?.classList.add("hidden");
        buttonText.textContent = "Régler maintenant";

        if (error) {
            showMessage(error.message);
        }
    };

    const checkStatus = async () => {
        const clientSecret = new URLSearchParams(window.location.search).get(
            "payment_intent_client_secret"
        );

        if (!clientSecret || !stripe.value) return;

        const { paymentIntent } = await stripe.value.retrievePaymentIntent(
            clientSecret
        );

        switch (paymentIntent.status) {
            case "succeeded":
                window.location = "/thankyou?payment_success=1"
                break;
            case "processing":
                showMessage("⏳ Paiement en cours...");
                break;
            case "requires_payment_method":
                showMessage("❌ Paiement échoué, réessayez.");
                break;
            default:
                showMessage("❗ Une erreur est survenue.");
        }
    };

    const showMessage = (message) => {
        const msgEl = document.getElementById("payment-message");
        if (msgEl) {
            msgEl.textContent = message;
            msgEl.classList.remove("hidden");
        }
    };

    return {
        initialize,
        handleSubmit,
        checkStatus,
    };
}
