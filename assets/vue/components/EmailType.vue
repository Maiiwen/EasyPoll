<template>
    <div>
        <!--        use bootstrap to generate choice inputs/checkboxes/radios -->
        <div class=" mb-3">
            <input type="email" class="form-control" :id="question.id" placeholder="name@example.com" v-model="value">
        </div>
        {{ value }}
        {{ question.answer }}
    </div>
</template>

<script>

export default {
    name: "EmailType",
    props: {
        question: {
            type: Object,
            default: null
        },
    },
    emits: ['update-question'],
    computed:
        {
            id() {
                return this.question.id
            },
        },
    data() {
        return {
            value: ''
        }
    },
    watch: {
        value() {
            this.$emit('update-question', { ... this.question, answer: this.value })
        }
    },

}
</script>

<style lang="scss" scoped>

</style>