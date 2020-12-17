<template>
  <div class="card">
    <button
      class="btn card__button--delete bg--danger"
      title="Delete Card"
      @click="deleteCard(index)"
    >
      -
    </button>
    <button
      class="btn card__button--edit bg--success"
      title="Edit Card"
      @click="$modal.show(cardTitle)"
    >
      edit
    </button>
    <div class="card__grabber btn">...</div>
    <div class="card__title">{{ cardTitle }}</div>
    <Modal :name="cardTitle" @before-close="updateCard" ref="cardModal">
      <div slot="top-right">
        <button @click="$modal.hide('foo')">
          hide modal
        </button>
      </div>
      <CardForm :title="cardTitle" :content="cardContent" />
    </Modal>
  </div>
</template>

<script>
import CardForm from "./CardForm";

export default {
  name: "Card",
  components: {
    CardForm
  },
  props: {
    title: {
      type: String,
      default: "Card Title"
    },
    content: {
      type: String,
      default: "Card Content"
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
      const cardTitle = event.ref.querySelector('.form--card .card__form__title');
      const cardContent = event.ref.querySelector('.form--card .card__form__content');
      this.cardTitle = cardTitle.value ?? this.cardTitle;
      this.cardContent = cardContent.value ?? this.cardContent;
    }
  },
  data() {
    return {
      cardTitle: this.title,
      cardContent: this.content
    }
  }
};
</script>

<style lang="scss">
.card {
  border: 1px solid black;
  margin: 1rem 0;
  padding: 2rem 0;
  text-align: left;
  max-height: 200px;
  overflow: hidden;
  position: relative;
  &__button {
    &--delete {
      position: absolute;
      top: 0.25rem;
      right: 0.25rem;
    }
    &--edit {
      position: absolute;
      top: 0.25rem;
      right: 2.25rem;
    }
  }
  &__grabber {
    position: absolute;
    top: 0;
    left: 0.2rem;
    width: 1.5rem;
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
