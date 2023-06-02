<template>
    <div>
        <!--        use bootstrap to generate choice inputs/checkboxes/radios -->
        <div class=" mb-3">
            <input type="text" class="form-control" :id="question.id" :placeholder="question.placeholder ?? ' '" v-model="value">
        </div>
        {{ value }}
        {{ question.answer }}
    </div>
</template>

<script>

export default {
    name: "TextType",
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