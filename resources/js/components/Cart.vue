<template>
    <div class="group">
        <h5>Valda tider <span v-if="slots.length" class="badge badge-pill badge-primary">{{ slots.length }}</span></h5>
        <ul>
            <li v-for="slot in slots">
                {{ slot.time }} <strong>{{ teachers[slot.teacher_id].name }}</strong> <span v-if="teachers[slot.teacher_id].room">({{ teachers[slot.teacher_id].room }})</span>
            </li>
        </ul>
    </div>
</template>

<script>
    import state from '../state.js'

    export default {
        props: {
            teachers: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                state,
            }
        },
        computed: {
            slots: function() {
                let list = []
                $.each(state.bookedSlots, function( key, value ) {
                  list.push(value);
                });
                return list.sort(function(a,b){
                    let atime = parseInt(a.time.replace(':',''));
                    let btime = parseInt(b.time.replace(':',''));
                    return (atime < btime) ? -1 : (atime > btime) ? 1 : 0;
                  });
            },
        }
    }
</script>
