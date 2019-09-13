<template>
    <div>
        <select class="form-control" id="signup-grade" name="grade" required>
            <option value="">Välj klass</option>
            <option v-for="grade in grades" v-if="grade.event_id==eventState" :value="grade.id">{{ grade.name }}</option>
        </select>
    </div>
</template>
<script>
    import state from '../state.js'

    export default {
        props: {
            grades: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                state
            }
        },
        computed: {
            eventState: function() {
                return this.state.event
            },
        }
    }
</script>
