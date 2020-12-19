<template>
  <div class="card" ref="card">
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
        <div class="card__movers">
            <button @click.prevent="moveCard('up')" aria-label="move card up" class="flex--center card__mover card__mover--up">^</button>
            <button @click.prevent="moveCard('left')" aria-label="move card left" class="flex--center card__mover card__mover--left">&laquo;</button>
            <button @click.prevent="moveCard('right')" aria-label="move card right" class="flex--center card__mover card__mover--right">&raquo;</button>
            <button @click.prevent="moveCard('down')" aria-label="move card down" class="flex--center card__mover card__mover--down"></button>
            <!-- <div class="card__grabber btn">...</div> -->
        </div>
    </div>
    <div v-if="loading" class="loading flex--center">
        <PacmanLoader color="rgba(0,0,0,.2)" />
    </div>
    <div v-if="!loading" class="card__title">{{ currentCard.title }}</div>
    <Modal :name="'card_'+ currentCard.id" @before-close="updateCard" ref="cardModal">
      <div slot="top-right">
        <button @click="$modal.hide('card_' + currentCard.id)">
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
import PacmanLoader from "./PacmanLoader";

export default {
  name: "Card",
  components: {
    CardForm,
    PacmanLoader
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
      this.loading = true;
      this.currentCard.title = event.ref.querySelector('.form--card .card__form__title').value;
      this.currentCard.content = event.ref.querySelector('.form--card .card__form__content').value;
      Axios.post("api/cards/" + this.currentCard.id, this.currentCard)
        .then(response => {
          this.currentCard = response.data;
          this.loading = false;
        });
    },
    moveCard(direction) {
      const existingColumn = this.currentCard.column_id;
      const cardCount = this.$refs.card.parentNode.children.length;
      const currentColEl = document.querySelector('#column-' + existingColumn);
      const columnCount = document.querySelectorAll('.column').length;

      if(direction === 'left') {
        if(this.currentCard.column.sort_order > 0) {
          const prevColEl = currentColEl.previousSibling;
          this.currentCard.column_id = prevColEl.dataset.colId;
        } else {
            return;
        }
      }

      if(direction === 'right') {
          console.log(this.currentCard.column.sort_order, columnCount);
        if(this.currentCard.column.sort_order < columnCount - 1) {
          const nextColEl = currentColEl.nextSibling;
          this.currentCard.column_id = nextColEl ? nextColEl.dataset.colId : this.currentCard.column_id;
        } else {
          return;
        }
      }

      if(direction === 'up') {
        if(cardCount > 1 && this.currentCard.sort_order > 0) {
          this.currentCard.sort_order = this.currentCard.sort_order - 1;
        } else {
          return;
        }
      }

      if(direction === 'down') {
        if(cardCount > 1 && this.currentCard.sort_order < cardCount - 1) {
          this.currentCard.sort_order = this.currentCard.sort_order + 1;
        } else {
          return;
        }
      }

      this.loading = true;

      Axios.post("api/cards/" + this.currentCard.id, this.currentCard)
      .then(response => {
          if(existingColumn !== response.data.column_id) {// Pass event up to the page to reload all cols
            this.$emit('reloadColumn');
          } else {
            this.$emit('reloadColumn', response.data.column_id);
        }
        this.loading = false;
      })
      .catch(err => {
          console.error(err);
          this.loading = false;
      });
    }
  },
  data() {
    return {
      loading: false,
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

  &__movers {
    width: 6rem;
    display: flex;
    flex-wrap: wrap;
  }
  &__mover {
      height: 1rem;
      font-size: 0.8rem;
      line-height: 0.7rem;
      text-align: center;
      background: #eee;
      padding: 0.25rem;
      &--up,
      &--down {
        width: 100%;
      }
      &--down::before {
        content: "\2304";
        line-height: .5rem;
        margin-top: -.4rem;
      }
      &--left,
      &--right {
        margin: 0.2rem;
        width: 2.8rem;
        line-height: .6rem;
      }
      &--left {
          margin-left: 0;
      }
      &--right {
          margin-right: 0;
      }
  }

  &__grabber {
    width: 29px;
    height: 30px;
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
