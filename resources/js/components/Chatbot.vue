<template>
    <div class="inner">
        <div v-if="is_started">
            <div class="messages">
                <div v-for="reply in conversation">
                    <div v-if="reply[0] == 'bot'" class="bot">
                        <p>{{ reply[1] }}</p>
                    </div>

                    <div v-if="reply[0] == 'user'" class="user">
                        <p>{{ reply[1] }}</p>
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
                conversation: [],
                preferred: {
                    "temp": null,
                    "location": null,
                }
            };
        },

        computed: {
            questions: function() {
                return [
                    "Hi There! What\'s your name?", // 0

                    `Hello ${this.name}! Are you looking for a Hot, Mild or Cold destination?`, // 1

                    `Nice choice! ${this.preferred["temp"]} is my favourite too! What about location?
                    City, Sea, or Mountain?`,

                    `Great. So are you planning on being lazy or active whilst away?`
                ];
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
                this.preferred = {
                    "temp": null,
                    "location": null,
                };
            },

            pushBot(index, reply = null) {
                if (reply) {
                    this.conversation.push(['bot', reply]);
                } else {
                    this.conversation.push(['bot', this.questions[index]]);
                }
            },

            pushUser(reply) {
                this.conversation.push(['user', reply]);
            },

            sanitise(string) {
                string = string.trim();

                return string;
            },

            updateChat(event) {
                const reply = this.sanitise(event.target.elements.message.value);
                event.target.elements.message.value = '';

                if (this.current_question == 0) {
                    this.name = reply;
                }

                this.pushUser(reply);

                if (this.checkReply(reply)) {
                    this.current_question++;

                    this.pushBot(this.current_question);
                } else {
                    this.pushBot(null, "Sorry, I did not quite understand that.");
                }
            },

            checkReply(reply) {
                let is_expected = true;
                const lower_reply = reply.toLowerCase();

                switch (this.current_question) {
                    case 0:
                        break;
                    case 1: 
                        switch(lower_reply) {
                            case 'hot':
                                this.preferred["temp"] = 'Hot';
                                break;
                            case 'mild':
                                this.preferred["temp"] = 'Mild';
                                break;
                            case 'cold':
                                this.preferred["temp"] = 'Cold';
                                break;
                            default: 
                                is_expected = false;
                        }
                        break;
                    case 2: 
                        switch(lower_reply) {
                            case 'city':
                                this.preferred["location"] = 'city';
                                break;
                            case 'sea':
                                this.preferred["location"] = 'sea';
                                break;
                            case 'mountain':
                                this.preferred["location"] = 'mountain';
                                break;
                            default: 
                                is_expected = false;
                        }
                        break;
                    default:
                        is_expected = false;
                }

                return is_expected;
            }
        }
    }
</script>