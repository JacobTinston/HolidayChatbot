<template>
    <div class="inner">
        <div v-if="is_started">
            <div class="messages">
                <div v-for="reply in conversation">
                    <div v-if="reply[0] == 'bot'" class="bot">
                        <p v-html="reply[1]"></p>
                    </div>

                    <div v-if="reply[0] == 'user'" class="user">
                        <p v-html="reply[1]"></p>
                    </div>
                </div>
            </div>

            <form @submit.prevent="updateChat">
                <input type="text" name="message" required>
                <button type="submit">Send</button>
            </form>
        </div>

        <button @click="startChat()" v-if="!is_started">Start Chat</button>
        <button @click="stopChat()" v-if="is_started">Stop Chat</button>
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
                    this.pushBot(0);
                }
            },

            stopChat() {
                this.is_started = false;
                this.name = null;
                this.current_question = 0;
                this.conversation = [];
            },

            pushBot(index) {
                this.conversation.push(['bot', this.questions[index]]);
            },

            pushUser(reply) {
                this.conversation.push(['user', reply]);
            },

            updateChat(event) {
                const reply = event.target.elements.message.value;
                event.target.elements.message.value = '';

                if (this.current_question == 0) {
                    this.name = reply;
                }

                this.pushUser(reply);

                this.current_question++;

                this.pushBot(this.current_question);
            },
        }
    }
</script>