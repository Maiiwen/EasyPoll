<template>

    <Multiselect v-if="!expanded && multiple" mode="tags" v-model="selected" :options="optionList" :multiple="multiple" :searchable="true" placeholder="Choisissez une ou plusieurs options">
                 ></Multiselect>
    <select v-if="!expanded && !multiple" class="form-select" :multiple="multiple" :id="'quest' + id" v-model="selected">
        <option selected disabled value="0" v-if="!multiple">Choisissez une option</option>
        <option v-for="opt in options" :value="opt">{{ opt.libelle }}</option>
    </select>
    <div class="form-check" v-if="expanded">
        <div v-for="option in options">
            <input class="form-check-input" :type="multiple ? 'checkbox' : 'radio'" :id="'choice'+id+'_'+option.id"
                   name="id"
                   :value="option" v-model="selected">
            <label class="form-check-label" :for="'choice'+id+'_'+option.id">
                {{ option.libelle }}
            </label>
        </div>
    </div>
</template>

<script>
import Multiselect from '@vueform/multiselect'

export default {
    name: "ChoiceType",
    components: {
        Multiselect,
    },
    emits: ['update-question'],
    props: {
        question: {
            type: Object,
            default: null
        },
    },
    computed:
        {
            id() {
                return this.question.id
            },
            options() {
                return this.question.answers
            },
            multiple() {
                return this.question.multiple ?? false
            },
            expanded() {
                return this.question.expanded ?? false
            },
            optionList() {
                if (this.question.multiple) {
                    return this.question.answers.map((el) => {
                        el.value = {id: el.id, libelle: el.libelle};
                        el.label = el.libelle;
                        el.name = el.libelle;
                        return el;
                    })
                }
            }
        },
    data() {
        return {
            selected: this.question.multiple ? [] : 0
        }
    },
    watch: {
        selected() {
            this.$emit('update-question', {...this.question, selected: this.selected})
        }
    },

}
</script>

<style lang="scss" scoped>
@import '@vueform/multiselect/themes/default.css';
</style>