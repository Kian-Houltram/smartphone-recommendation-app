// Tracks current index of the carousel. 
let currentIndex = 0;

/**
 * scrolls the carousel left or right depending on the direction chosen
 */
function scrollCarousel(direction) {
  // Gets the carousel track container.
  const track = document.getElementById('carouselTrack');

  // Gets all the individual cards in the carousel.
  const cards = document.querySelectorAll('.phone-card');

  // Calculates the width of a single card including margin.
  const cardWidth = cards[0].offsetWidth + 32;

  // Defines how many cards should be visible at once.
  const visibleCards = 3;

  //Prevents scrolling beyond the range of cards.
  const maxIndex = cards.length - visibleCards;
  
  // Updates the current index based on scroll direction.
  currentIndex += direction;
  if (currentIndex < 0) currentIndex = 0;
  if (currentIndex > maxIndex) currentIndex = maxIndex;

  // Applies the horizontal scroll via transform.
  track.style.transform = `translateX(-${cardWidth * currentIndex}px)`;
}