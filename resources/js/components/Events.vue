<template>
    <div>
        <select class="form-control" id="signup-event" name="event" v-model="selectedEvent" @change="setEvent(selectedEvent)" required>
            <option value="">Välj tillfälle</option>
            <option v-for="event in events" :value="event.id">{{ event.title }}</option>
        </select>
    </div>
</template>

<script>
    import state from '../state.js'

    export default {
        props: {
            events: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                state,
                selectedEvent: 0
            }
        },
        methods: {
            setEvent: function(id) {
                this.state.event = id;
            },
        }
    }
</script>
