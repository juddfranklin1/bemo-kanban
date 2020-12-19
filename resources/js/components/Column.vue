<template>
  <div class="column" :id="'column-' + id">
    <div class="column__controls">
        <button
        class="btn column__button--delete bg--danger"
        title="Delete Column"
        @click="deleteColumn"
        >
        -
        </button>
        <button
        class="btn column__button--add bg--success text--white"
        title="Add Card to Column"
        @click="addCard"
        >
        + Card
        </button>
    </div>
    <h2 class="column__title">{{ title }}</h2>
    <transition-group tag="div" class="column__content" :id="'column_container_' + id" name="slide-fade">
      <Card
        @reloadColumn="reloadColumn"
        v-for="(card) in currentCards"
        @deleteCard="removeCard(card.id)"
        :key="'card-' + card.id"
        :card="card"
        :column_id="id"
        :index="card.id"
      />
    </transition-group>
    <div v-if="currentCards.length === 0">
      <p class="text--center text--danger">
        <b>No Cards Currently in this column</b>
      </p>
    </div>
  </div>
</template>

<script>
import Card from "./Card";
import Axios from "axios";

export default {
  name: "Column",
  props: {
    title: {
      type: String,
      default: "Column Title"
    },
    id: {
      type: Number
    },
    index: {
      type: Number
    },
    cards: {
      type: Array,
      default: () => []
    }
  },
  components: {
    Card
  },
  methods: {
    deleteColumn() {
      this.$emit("deleteColumn", this.id);
    },
    addCard() {// Add a card to the database and update component state
      const now = new Date();
      const card = {
        title: "New Card " + now.toUTCString()
      };
      Axios.post("api/cards", {
        title: card.title,
        column_id: this.id
      })
      .then(response => {// Async update of card state
        this.currentCards.unshift(response.data)// Let Laravel deliver the relevant model data
      });
    },
    reloadColumn(payload) {
        if(payload === this.id) {
            Axios.get("api/columns/" + this.id)
            .then(response => {
                this.currentCards = response.data.cards
            })
        } else {
            this.$emit('reloadAllCols');
        }
    },
    removeCard(id) {
      Axios.delete("api/cards/" + id)
        .then(response => this.currentCards = this.currentCards.filter(card => card.id !== id));
    }
  },
  watch: {
      cards: function(newVal, oldVal) {
          this.currentCards = newVal
      }
  },
  data() {
    return {
      currentCards: this.cards
    };
  }
};
</script>

<style lang="scss">
// Transition Styles for Cards
.slide-fade-enter-active {
  transition: all 0.3s ease;
}
.slide-fade-leave-active {
  transition: all 0.8s ease-in-out;
}
.slide-fade-enter,
.slide-fade-leave-to {
  transform: scale3d(0.5, 0.5, 0.5);
  opacity: 0;
  max-height: 0;
}

.column {
  flex-grow: 1;
  border: 1px solid black;
  border-radius: 4px;
  margin: 0.25rem;
  position: relative;
  padding-top: 0;
  display: flex;
  flex-direction: column;
  &__controls {
      padding: 2px;
      background-color: #fafafa;
      display:flex;
      justify-content: space-between;
  }
  &__content {
      padding: 2px;
  }
}
</style>
