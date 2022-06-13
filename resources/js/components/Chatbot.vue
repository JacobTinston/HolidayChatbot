<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <button @click="startChat()" v-if="!is_started">Start Chat</button>

                    <div v-if="is_started">
                        <div v-for="reply in conversation">
                            <p v-html="reply"></p>
                        </div>

                        <form @submit.prevent="updateChat">
                            <input type="text" name="message" required>
                            <button type="submit">Send</button>
                        </form>

                        <button @click="stopChat()">Stop Chat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                is_started: false,
                name: null,
                current_question: 0,
                conversation: []
            };
        },

        computed: {
            questions: function() {
                return ["Hi There! What\'s your name?", `Hello ${this.name}!`];
            }
        },

        methods: {
            startChat() {
                this.is_started = true;
                if (this.current_question == 0) {
                    this.conversation.push(this.questions[0]);
                }
            },

            stopChat() {
                this.is_started = false;
                this.name = null;
                this.current_question = 0;
                this.conversation = [];
            },

            updateChat(event) {
                const reply = event.target.elements.message.value;

                if (this.current_question == 0) {
                    this.name = reply;
                }

                this.current_question++;

                this.conversation.push(this.questions[this.current_question]);
            },
        }
    }
</script>