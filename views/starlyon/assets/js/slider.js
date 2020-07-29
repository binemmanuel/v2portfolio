/**
 * File slider.js.
 *
 * This script is responsibe for displaying slides on the
 * StarLyon Theme.
 */

/* Slider */
const slider = $(".slider");
const slide = $$(".slide");

const prev_btn = $("#prev");
const next_btn = $("#next");

const auto_slide = true;
const timeout = 8000;
const transition = "all 1s ease-in-out";

let counter = 1;
const size = slide[0].clientWidth;

slider.style.transform = `translateX(${-(size * counter)}px)`;

const next_slide = () => {
	if (counter >= slide.length - 1) return;
	slider.style.transition = transition;
	counter++;
	slider.style.transform = `translateX(${-(size * counter)}px)`;
};

const prev_slide = () => {
	if (counter <= 0) return;
	slider.style.transition = transition;
	counter--;
	slider.style.transform = `translateX(${-(size * counter)}px)`;
};

next_btn.addEventListener("click", next_slide);
prev_btn.addEventListener("click", prev_slide);

if (auto_slide) {
	setInterval(next_slide, timeout);
}

slider.addEventListener("transitionend", () => {
	if (slide[counter].id === "last-child") {
		slider.style.transition = "none";
		counter = slide.length - 2;
		slider.style.transform = `translateX(${-(size * counter)}px)`;
	}

	if (slide[counter].id === "first-child") {
		slider.style.transition = "none";
		counter = slide.length - counter;
		slider.style.transform = `translateX(${-(size * counter)}px)`;
	}
});
/* Slider Ends */
