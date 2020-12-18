<template>
  <form class="form--card" @submit.prevent="updateCard" ref="cardForm">
    <input required type="hidden" class="card__form__id" name="cardTitle" id="card_id" :value="currentCard.id" />
    <label for="card_title">Title</label>
    <input required type="text" class="card__form__title" name="cardTitle" id="card_title" :value="currentCard.title" />

    <label for="card_content">Content</label>
    <textarea name="cardContent" class="card__form__content" id="card_content" v-model="currentCard.content"></textarea>
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
    card: {
      type: Object
    },
  },
  data() {
    return {
      currentCard: this.card
    };
  },
  methods: {
    updateCard($e) {
      this.$modal.hide('card_' + this.currentCard.id);
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
    padding: .5rem;
    margin: 0 0 1rem;
    border: 1px solid black;
  }
}
</style>
