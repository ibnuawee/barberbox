<template>
  <div>
    <h1>Chat</h1>
    <div class="chat-box">
      <div
        v-for="message in messages"
        :key="message.id"
        :class="{'sent': message.sender_id === userId, 'received': message.sender_id !== userId}"
        class="message"
      >
        <p>{{ message.message }}</p>
        <small>{{ formatDate(message.created_at) }}</small>
      </div>
    </div>
    <form @submit.prevent="sendMessage" class="message-form">
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
    this.loadMessages();
    window.Echo.channel('messages')
      .listen('MessageSent', (event) => {
        this.addMessage(event.message);
      })
      .error(error => {
        console.error('Error connecting to channel:', error);
      });
  },
  methods: {
    loadMessages() {
      axios.get(`/messages/${this.receiverId}`)
        .then(response => {
          this.messages = response.data;
        })
        .catch(error => {
          console.error('Error loading messages:', error);
        });
    },
    sendMessage() {
      axios.post('/messages', {
        receiver_id: this.receiverId,
        message: this.newMessage,
      }).then(response => {
        this.addMessage(response.data.message);
        this.newMessage = '';
      }).catch(error => {
        console.error('Error sending message:', error);
      });
    },
    addMessage(message) {
      this.messages.push(message);
    },
    formatDate(date) {
      return new Date(date).toLocaleString();
    },
  },
};
</script>

<style>
body {
  background-color: #000;
  color: #000;
  font-family: Arial, sans-serif;
}

h1 {
  text-align: center;
  margin-top: 20px;
}

.chat-box {
  display: flex;
  flex-direction: column;
  max-height: 500px;
  overflow-y: auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
  margin: 20px auto;
  background-color: #f7f7f7;
  width: 90%;
  max-width: 800px;
}

.message {
  margin-bottom: 10px;
  padding: 10px;
  border-radius: 5px;
  display: flex;
  flex-direction: column;
  max-width: 70%;
}

.sent {
  align-self: flex-end;
  background-color: #DCF8C6;
}

.received {
  align-self: flex-start;
  background-color: #FFFFFF;
}

.message p {
  margin: 0;
}

.message-form {
  display: flex;
  align-items: center;
  justify-content: center;
}

.message-form input {
  flex: 1;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-right: 10px;
  max-width: 700px;
  width: 80%;
}

.message-form button {
  padding: 10px 20px;
  border: none;
  background-color: #007BFF;
  color: white;
  border-radius: 5px;
  cursor: pointer;
}

.message-form button:hover {
  background-color: #0056b3;
}
</style>
