<template>
  <div class="card">
    <div class="card__controls">
        <button
        class="btn card__button card__button--delete bg--danger"
        title="Delete Card"
        @click="deleteCard(index)"
        >
        -
        </button>
        <button
        class="btn card__button card__button--edit bg--success text--white"
        title="Edit Card"
        @click="$modal.show('card_' + currentCard.id)"
        >
        edit
        </button>
        <div class="card__grabber btn">...</div>
    </div>
    <div class="card__title">{{ currentCard.title }}</div>
    <Modal :name="'card_'+ currentCard.id" @before-close="updateCard" ref="cardModal">
      <div slot="top-right">
        <button @click="$modal.hide('foo')">
          hide modal
        </button>
      </div>
      <CardForm :card="currentCard" />
    </Modal>
  </div>
</template>

<script>
import Axios from "axios";
import CardForm from "./CardForm";

export default {
  name: "Card",
  components: {
    CardForm
  },
  props: {
    card: {
        type: Object
    },
    column_id: {
        type: Number
    },
    index: {
      type: Number
    }
  },
  methods: {
    deleteCard(index) {
      this.$emit("deleteCard", index);
    },
    updateCard(event) {
      const cardId = event.ref.querySelector('.form--card .card__form__id').value;
      const cardTitle = event.ref.querySelector('.form--card .card__form__title').value;
      const cardContent = event.ref.querySelector('.form--card .card__form__content').value;
      Axios.post("/api/cards/" + cardId.value, {
          column_id: this.column_id,
          title: cardTitle,
          content: cardContent
      })
        .then(response => {
            this.currentCard = response.data;
        });
    }
  },
  data() {
    return {
      currentCard: this.card
    }
  }
};
</script>

<style lang="scss">
.card {
  border: 1px solid rgba(0, 0, 255, 0.3);
  background-color: rgba(0, 0, 255, 0.3);
  border-radius: 4px;
  margin: 1rem 0;
  padding: 0 0 1rem;
  text-align: left;
  max-height: 200px;
  overflow: hidden;
  position: relative;
  &__controls {
      background-color: rgba(230, 230, 230, 0.3);
      display: flex;
      padding: 2px 0;
      justify-content: flex-end;
      position: relative;
  }
  &__button {
      margin: 0 2px;
  }
  &__grabber {
    position: absolute;
    top: 0;
    left: 0.2rem;
    width: 29px;
    height: 30px;
    top: 3px;
    line-height: 25px;
    text-align: center;
    &.btn {
      border: 0;
      background: #eee;
      padding: 0 0 0.35rem;
      transform: rotate(90deg);
    }
  }
  &__title {
    font-size: 1.2rem;
    font-weight: 900;
    text-align: left;
    padding: 1rem;
  }
  &__body {
    padding: 1rem;
  }
}
</style>
