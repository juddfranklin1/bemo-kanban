<template>
  <form class="form--card" @submit.prevent="updateCard" ref="cardForm">
    <input required type="text" class="card__form__title" name="cardTitle" id="" :value="title" />
    <textarea name="cardContent" class="card__form__content" id="" v-model="cardContent"></textarea>
    <button
      class="btn column__button--submit bg--success"
      title="Update Card"
      type="submit"
    >
      Update Card
    </button>
  </form>
</template>

<script>
export default {
  name: "CardForm",
  props: {
    title: {
      type: String
    },
    content: {
      type: String
    }
  },
  data() {
    return {
      cardContent: this.content
    };
  },
  methods: {
    updateCard($e) {
      this.$modal.hide(this.title);
      this.$emit("test-event", $e.target);
    }
  }
};
</script>

<style lang="scss">
form {
  padding: 1rem;
  display: flex;
  flex-direction: column;
  input,
  textarea {
    margin: 0 0 1rem;
    border: 1px solid black;
  }
}
</style>
