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

                            <ChoiceType
                                    v-if="question.type === 'Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType'"
                                    :question="question" @update-question="updateQuestion">
                            </ChoiceType>

                            <TextType
                                    v-if="question.type === 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType'"
                                    :question="question" @update-question="updateQuestion">

                            </TextType>

                            <EmailType
                                    v-if="question.type === 'Symfony\\Component\\Form\\Extension\\Core\\Type\\EmailType'" :question="question" @update-question="updateQuestion">

                            </EmailType>

                            <!--                            <TelType-->
                            <!--                                    v-if="question.type === 'Symfony\\Component\\Form\\Extension\\Core\\Type\\TelType'">-->

                            <!--                            </TelType>-->

                            <!--                            <DateType-->
                            <!--                                    v-if="question.type === 'Symfony\\Component\\Form\\Extension\\Core\\Type\\DateType'">-->

                            <!--                            </DateType>-->

                            <!--                            <CheckboxType-->
                            <!--                                    v-if="question.type === 'Symfony\\Component\\Form\\Extension\\Core\\Type\\CheckboxType'">-->

                            <!--                            </CheckboxType>-->

                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <div v-for="question in poll.questions">
                        <div>{{ question.libelle }}</div>
                        <div>{{ question.answer }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from "axios";
import ChoiceType from "../components/ChoiceType.vue";
import TextType from "../components/TextType.vue";
import EmailType from "../components/EmailType.vue";

export default {
    name: "Formulaire",
    components: {EmailType, TextType, ChoiceType},
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
    methods: {
        submit() {
            axios.post('/api/poll/' + this.poll_uuid + '/submit', this.pollResponse)
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        updateQuestion(question) {
            console.log(question);
            this.poll.questions.find(q => q.id === question.id).answer = question.selected ?? question.answer ?? null;
        }
    }
}

</script>


<style lang="scss" scoped>

</style>