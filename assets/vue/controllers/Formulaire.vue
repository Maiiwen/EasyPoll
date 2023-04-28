<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>{{ poll.title }}</h1>
                    <p>{{ poll.description }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <form @submit.prevent="submit">
                        <div v-for="question in poll.questions" :key="question.id">
                            <h4>{{ question.libelle }}</h4>
                            {{ question }}

                            <ChoiceType
                                    v-if="question.type === 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType'"
                                    v-model="selected" :options="question.answers"
                                    :expanded="question.expanded ?? false"
                                    :multiple="question.multiple ?? false"
                                    :id="question.id">
                            </ChoiceType>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from "axios";
import ChoiceType from "../components/ChoiceType.vue";

export default {
    name: "Formulaire",
    components: {ChoiceType},
    props: {
        poll_uuid: {
            type: String,
            default: null
        },
    },
    data() {
        return {
            selected: this.value,
            poll: {},
            pollResponse: {}
        }
    },
    watch: {
        selected() {
            this.$emit('input', this.selected)
        }
    },
    mounted() {
        axios.get('/api/poll/' + this.poll_uuid)
            .then(response => {
                this.pollResponse = response.data;
                this.poll = this.pollResponse.poll;
                //     remove poll from pollResponse
                this.pollResponse.poll = null;
            })
            .catch(error => {
                console.log(error);
            });
    },
}

</script>


<style lang="scss" scoped>

</style>