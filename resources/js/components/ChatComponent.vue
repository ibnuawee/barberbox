<template>
  <div>
    <div class="chat-box">
      <div 
        v-for="message in messages" 
        :key="message.id" 
        :class="{'sent': message.sender_id === userId, 'received': message.sender_id !== userId}"
      >
        <p>{{ message.message }}</p>
        <small>{{ message.created_at }}</small>
      </div>
    </div>
    <form @submit.prevent="sendMessage">
      <input v-model="newMessage" type="text" placeholder="Type your message here..." required />
      <button type="submit">Send</button>
    </form>
  </div>
</template>

<script>
export default {
  props: ['userId', 'receiverId'],
  data() {
    return {
      messages: [],
      newMessage: '',
    };
  },
  mounted() {
    console.log('ChatComponent mounted');
    this.loadMessages();
    const channelName = `chat.${this.receiverId}`;
    console.log(`Listening to channel: ${channelName}`);

    window.Echo.channel('messages')
      .listen('MessageSent', (event) => {
        console.log(event);
        this.addMessage(event.message);
      })
      .error(error => {
        console.error('Error connecting to channel:', error);
      });

    // window.Echo.channel(`chat.${this.receiverId}`)
    //   .listen('MessageSent', (event) => {
    //     console.log(event);
    //     this.addMessage(event.message);
    //   })
    //   .error(error => {
    //     console.error('Error connecting to channel:', error);
    //   });
  },
  methods: {
    loadMessages() {
      console.log('Loading messages...');
      axios.get(`/messages/${this.receiverId}`)
        .then(response => {
          console.log('Messages loaded:', response.data);
          this.messages = response.data;
        })
        .catch(error => {
          console.error('Error loading messages:', error);
        });
    },
    sendMessage() {
      console.log('Sending message...');
      axios.post('/messages', {
        receiver_id: this.receiverId,
        message: this.newMessage,
      }).then(response => {
        console.log('Message sent:', response.data.message);
        this.messages.push(response.data.message);
        this.newMessage = '';
      }).catch(error => {
        console.error('Error sending message:', error);
      });
    },
    addMessage(message) {
      this.messages.push(message);
    },
  },
};
</script>

<style>
.sent {
  text-align: right;
  background-color: #DCF8C6;
  padding: 10px;
  border-radius: 5px;
  margin: 5px;
  display: inline-block;
}

.received {
  text-align: left;
  background-color: #FFFFFF;
  padding: 10px;
  border-radius: 5px;
  margin: 5px;
  display: inline-block;
}
</style>
