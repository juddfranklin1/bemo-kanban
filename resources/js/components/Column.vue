<template>
  <div class="column" :id="'column-' + index">
    <button
      class="btn column__button--delete bg--danger"
      title="Delete Column"
      @click="deleteColumn"
    >
      -
    </button>
    <button
      class="btn column__button--add bg--success"
      title="Add Card to Column"
      @click="addCard"
    >
      + Card
    </button>
    <h2 class="column__title">{{ title }}</h2>
    <transition-group tag="div" name="slide-fade">
      <Card
        @deleteCard="removeCard"
        v-for="(card, index) in currentCards"
        :key="card.title"
        :title="card.title"
        :index="index"
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
      type: Array
    }
  },
  components: {
    Card
  },
  methods: {
    deleteColumn() {
      this.$emit("deleteColumn", this.id);
    },
    addCard() {
      this.currentCards.unshift({
        title: this.title + ": Card " + (this.currentCards.length + 1)
      });
    },
    removeCard(index) {
      this.currentCards.splice(index, 1);
    }
  },
  data() {
    return {
      currentCards: [
        {
          title: this.title + ": Card 1"
        },
        {
          title: this.title + ": Card 2"
        },
        {
          title: this.title + ": Card 3"
        },
        {
          title: this.title + ": Card 4"
        }
      ]
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
  padding: 2px;
  margin: 0.25rem;
  position: relative;
  padding-top: 2rem;
  display: flex;
  flex-direction: column;
  &__button {
    &--delete {
      position: absolute;
      top: 0.25rem;
      right: 0.25rem;
    }
    &--add {
      position: absolute;
      top: 0.25rem;
      left: 0.25rem;
    }
  }
}
</style>
