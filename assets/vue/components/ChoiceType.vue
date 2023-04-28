<template>
    <div>
        <!--        use bootstrap to generate choice inputs/checkboxes/radios -->

        <div v-if="!expanded">
            <select class="form-select" :multiple="multiple" v-model="selected">
                <option value="0" selected>Open this select menu</option>
                <option v-for="opt in options" :value="opt.id">{{ opt.libelle }}</option>
            </select>
        </div>
        <div v-else>
            <div class="form-check" v-if="multiple">
                <div v-for="option in options">
                    <input class="form-check-input" type="checkbox" :id="id+'_'+option.id" :value="option.id"  v-model="selected">
                    <label class="form-check-label" :for="id+'_'+option.id">
                        {{ option.libelle }}
                    </label>
                </div>
            </div>
            <div class="form-check" v-else>
                <div v-for="option in options">
                    <input class="form-check-input" type="radio" :id="id+'_'+option.id" name="id" :value="option.id" id="flexCheckDefault" v-model="selected">
                    <label class="form-check-label" :for="id+'_'+option.id">
                        {{ option.libelle }}
                    </label>
                </div>
            </div>
        </div>
        {{ selected }}
    </div>
</template>

<script>
export default {
    name: "ChoiceType",
    props: {
        options: {
            type: Array,
            default: () => []
        },
        expanded: {
            type: Boolean,
            default: false
        },
        multiple: {
            type: Boolean,
            default: false
        },
        id : {
            type: String,
            default: null
        }
    },
    data() {
        return {
            selected: []
        }
    },
    watch: {
        selected() {
            this.$emit('input', this.selected)
        }
    },
    mounted() {
        console.log(this.options)
    }
}
</script>

<style lang="scss" scoped>

</style>