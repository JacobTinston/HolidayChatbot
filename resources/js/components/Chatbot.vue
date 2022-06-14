<template>
    <div class="smartphone">
        <div id="messages">
            <div v-for="reply in conversation">
                <div v-if="reply[0] == 'bot'" class="message bot">
                    <p v-html="reply[1]"></p>
                </div>

                <div v-if="reply[0] == 'user'" class="message user">
                    <p>{{ reply[1] }}</p>
                </div>
            </div>
        </div>

        <form @submit.prevent="updateChat">
            <input type="text" name="message" placeholder="Type here..." required>
            <button type="submit">Send</button>
        </form>

        <div class="button" @click="resetChat"></div>
    </div>
</template>

<script>
    export default {
        mounted() {
            if (this.current_question == 0) {
                this.pushBot(0);
            }
        },

        data() {
            return {
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
                    City, Sea, or Mountain?`, // 2

                    `Great. So are you planning on being lazy or active whilst away?` //3
                ];
            }
        },

        methods: {
            resetChat() {
                this.name = null;
                this.current_question = 0;
                this.conversation = [];
                this.preferred = {
                    "temp": null,
                    "location": null,
                    "category": null
                };
                this.pushBot(0);
            },

            pushBot(index, reply = null) {
                setTimeout(() => {
                    if (reply) {
                        this.conversation.push(['bot', reply]);
                    } else {
                        this.conversation.push(['bot', this.questions[index]]);
                    }
                }, 100);
            },

            pushUser(reply) {
                this.conversation.push(['user', reply]);
            },

            sanitise(string) {
                string = string.replace(/[^a-z0-9áéíóúñü \,_-]/gim,"").trim();

                return string;
            },

            updateChat(event) {
                const reply = this.sanitise(event.target.elements.message.value);
                event.target.elements.message.value = '';

                if (this.current_question == 0) {
                    this.name = reply;
                }

                this.pushUser(reply);

                if (this.checkReply(reply) == 'end') {
                    this.current_question++;

                    this.checkDestinations();
                } else if (this.checkReply(reply)) {
                    this.current_question++;

                    this.pushBot(this.current_question);
                } else {
                    this.pushBot(null, "Sorry, I did not quite understand that.");
                }

                this.scrollBottom();
            },

            scrollBottom() {
                const messages = document.getElementById('messages');

                setTimeout(() => {
                    messages.scroll({ top: messages.scrollHeight, behavior: "smooth"})
                }, this.questions[this.current_question] ? 100 : 300);
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
                                this.preferred["location"] = 'City';
                                break;
                            case 'sea':
                                this.preferred["location"] = 'Sea';
                                break;
                            case 'mountain':
                                this.preferred["location"] = 'Mountain';
                                break;
                            default: 
                                is_expected = false;
                        }
                        break;
                    case 3: 
                        switch(lower_reply) {
                            case 'lazy':
                                is_expected = 'end';
                                this.preferred["category"] = 'Lazy';
                                break;
                            case 'active':
                                is_expected = 'end';
                                this.preferred["category"] = 'Active';
                                break;
                            default: 
                                is_expected = false;
                        }
                        break;
                    default:
                        is_expected = false;
                }

                return is_expected;
            },

            async checkDestinations () {
                if (this.preferred) {
                    let timeout = 500;

                    let suggested_destinations = await axios.post("/api/show", this.preferred).then(response => {
                        return response.data;
                    });

                    if (suggested_destinations.length) {
                        this.pushBot(null, `That\'s everything! Here is ${suggested_destinations.length} destinations we found that we think you might like:`);
                    } else {
                        this.pushBot(null, "Unfortunately we couldn't find a suitable destination. Please try narrowing your search terms. <br> Click the button on the phone to reset.");
                    }

                    suggested_destinations.forEach(destination => {
                        this.pushBot(null, `
                            Country: ${destination["Country"]} <br>
                            City: ${destination["City"]} <br>
                            Hotel Name: ${destination["HotelName"]} <br>
                            Price/Night: £${destination["PricePerPerNight"]} <br>
                            <a href="/">Book Here Now!</a>
                        `);
                    });
                }
            }
        }
    }
</script>