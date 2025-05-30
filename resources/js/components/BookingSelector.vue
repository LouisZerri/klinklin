<template>
    <div class="booking-toolbar">
        <!-- DATE -->
        <div class="input-floating-wrapper">
            <i class="fa-regular fa-calendar icon-left"></i>
            <input type="date" class="booking-input" v-model="localDate" :readonly="isReadonly" placeholder=" " />
            <label :class="{ active: localDate }">Date</label>
        </div>

        <!-- TIMESLOT -->
        <div class="input-floating-wrapper">
            <i class="fa-solid fa-clock icon-left"></i>
            <select class="booking-input" v-model="localTimeslot" :disabled="isReadonly" placeholder=" ">
                <option v-for="slot in slots" :key="slot" :value="slot">{{ slot }}</option>
            </select>
            <label :class="{ active: localTimeslot }">Créneau horaire</label>
        </div>

        <!-- ADDRESS -->
        <div class="input-floating-wrapper">
            <i class="fa-solid fa-location-dot icon-left"></i>
            <input type="text" class="booking-input input-address" v-model="localAddress" :readonly="isReadonly"
                placeholder=" " />
            <label :class="{ active: localAddress }">Adresse</label>
        </div>

        <!-- ACTION -->
        <button class="edit-button" @click="toggleEdit">
            {{ isReadonly ? 'Modifier' : 'Valider' }}
        </button>
    </div>
</template>


<script setup>
import { ref, onMounted } from 'vue'

const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
    slots: {
        type: Array,
        default: () => ['08h00 - 10h00', '10h00 - 12h00', '12h00 - 14h00', '14h00 - 16h00', '16h00 - 18h00'],
    },
    updateUrl: {
        type: String,
        default: '/order/update-infos'
    },
    csrfToken: {
        type: String,
        required: true
    }
})

const localDate = ref('')
const localTimeslot = ref('')
const localAddress = ref('')
const isReadonly = ref(true)


// Initialisation des valeurs
onMounted(() => {
    if (props.order.orderDate) {
        localDate.value = props.order.orderDate.split('T')[0];
    }

    if (props.order.timeslot) {
        localTimeslot.value = props.order.timeslot;
    }

    if (props.order.address) {
        localAddress.value = props.order.address;
    }
});


const toggleEdit = async () => {
    if (!isReadonly.value) {
        // Découper l'adresse complète
        const addressParts = localAddress.value.split(',').map(part => part.trim());

        const mainAddress = addressParts[0] || '';
        const complement = addressParts.length === 3 ? addressParts[1] : null;
        const cityZip = addressParts[addressParts.length - 1] || '';

        const zipCodeMatch = cityZip.match(/^(\d{4,5})\s+(.*)$/);
        const zipCode = zipCodeMatch ? zipCodeMatch[1] : '';
        const city = zipCodeMatch ? zipCodeMatch[2] : '';

        const formData = {
            order_date: localDate.value,
            timeslot: localTimeslot.value,
            address: mainAddress,
            complement: complement,
            zip_code: zipCode,
            city: city,
            _token: props.csrfToken
        };

        try {
            const response = await fetch(props.updateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': props.csrfToken
                },
                body: JSON.stringify(formData)
            });

            if (response.ok) {
                console.log('Données sauvegardées avec succès');
            } else {
                console.error('Erreur lors de la sauvegarde');
            }
        } catch (error) {
            console.error('Erreur réseau:', error);
        }
    }

    isReadonly.value = !isReadonly.value;
}

</script>
