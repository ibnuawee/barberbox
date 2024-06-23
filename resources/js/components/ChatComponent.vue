<template>
    <div>
      <div class="chat-box">
        <div v-for="message in messages" :key="message.id" :class="{'sent': message.sender_id === userId, 'received': message.sender_id !== userId}">
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
      window.Echo.private(`chat.${this.receiverId}`)
        .listen('MessageSent', (e) => {
          console.log('Message received:', e.message);
          this.messages.push(e.message);
        });
    },
    methods: {
      loadMessages() {
        console.log('Loading messages...');
        axios.get('/messages')
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
    },
  };
  </script>
  
  <style>
  .sent {
    text-align: right;
  }
  .received {
    text-align: left;
  }
  </style>
  