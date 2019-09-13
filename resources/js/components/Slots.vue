<template>
    <ul>
        <li v-for="slot in slots">
            <input type="radio" :name="'slot[' + slot.teacher_id + '][]'" :value="slot.id" :disabled="slot.is_reserved_or_booked && slot.is_reserved_or_booked != visitor_id" :checked="bookedSlot && bookedSlot.id == slot.id" />
            <label @click.prevent="book(slot)">{{ slot.time }}</label>
        </li>
    </ul>
</template>

<script>
    import state from '../state.js'

    export default {
        props: {
            slots: {
                type: Array,
                required: true
            },
            visitor_id: {
                type: Number,
                required: true
            },
            reserved_slot: {
                type: Array
            }
        },
        mounted() {
            let that = this
            if(that.reserved_slot.length > 0) {
                $.each(that.slots, function(key, slot) {
                    if(slot.id == that.reserved_slot[0].id) {
                        that.bookedSlot = slot
                        Vue.set(that.state.bookedSlots, slot.teacher_id, slot)
                    }
                });
            }
        },
        data() {
            return {
                state,
                bookedSlot: null,
            }
        },
        methods: {
            book(slot) {
                if(this.bookedSlot && this.bookedSlot.id == slot.id) {
                    this.bookedSlot = null
                    Vue.delete(this.state.bookedSlots, slot.teacher_id)
                    $.ajax({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: "/api/slot/release",
                        data: { 
                            'slot_id': slot.id
                        },
                    })
                }
                else {
                    $.ajax({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'POST',
                        url: "/api/slot/reserve",
                        data: { 
                            'slot_id': slot.id
                        },
                    }).done(() => {
                        this.bookedSlot = slot
                        Vue.set(this.state.bookedSlots, slot.teacher_id, slot)
                    }).fail((xhr, status, text) => {
                        if(xhr.status == 409) {
                            alert("Du har redan reserverat en tid på samma klockslag.")
                        }
                        else {
                            alert("Tiden kunde tyvärr inte reserveras, då den reserverats av någon annan.")
                        }
                    })
                }
            },
        },
    }
</script>
