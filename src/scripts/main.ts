import "../styles/main.css";
import Lenis from "lenis";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
import { SplitText } from "gsap/SplitText";

gsap.registerPlugin(ScrollTrigger, ScrollToPlugin, SplitText);

const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
const finePointer = window.matchMedia("(pointer: fine)").matches;

let lenis: Lenis | null = null;

const initializeSmoothScroll = () => {
  if (reducedMotion) return;

  lenis = new Lenis({
    duration: 1.15,
    smoothWheel: true,
    syncTouch: false,
    wheelMultiplier: 0.9,
  });

  lenis.on("scroll", ScrollTrigger.update);
  gsap.ticker.add((time) => lenis?.raf(time * 1000));
  gsap.ticker.lagSmoothing(0);
};

const initializeAnchorLinks = () => {
  document.querySelectorAll<HTMLAnchorElement>("[data-scroll-link]").forEach((link) => {
    link.addEventListener("click", (event) => {
      const target = link.getAttribute("href");
      if (!target?.startsWith("#")) return;

      const destination = document.querySelector(target);
      if (!destination) return;

      event.preventDefault();
      if (lenis) {
        lenis.scrollTo(destination as HTMLElement, { offset: 0, duration: 1.35 });
      } else {
        destination.scrollIntoView({ behavior: reducedMotion ? "auto" : "smooth" });
      }
    });
  });
};

const initializeHero = () => {
  const title = document.querySelector<HTMLElement>("[data-hero-title]");
  if (!title || reducedMotion) return;

  const split = SplitText.create(title, {
    type: "lines,words",
    mask: "lines",
    linesClass: "split-line",
    aria: "auto",
  });

  gsap
    .timeline({ defaults: { ease: "power4.out" } })
    .from(".hero__top", { y: -28, autoAlpha: 0, duration: 0.8 })
    .from(".hero__kicker", { y: 20, autoAlpha: 0, duration: 0.65 }, 0.2)
    .from(split.words, { yPercent: 115, rotate: 2, duration: 1.25, stagger: 0.035 }, 0.28)
    .from("[data-hero-lead]", { y: 30, autoAlpha: 0, duration: 0.85 }, 0.72)
    .from("[data-hero-actions]", { y: 24, autoAlpha: 0, duration: 0.75 }, 0.84)
    .from("[data-hero-date]", { x: 30, autoAlpha: 0, duration: 0.7 }, 0.78)
    .from(".hero__bottom", { y: 18, autoAlpha: 0, duration: 0.65 }, 0.95);

  gsap.to(".hero__ambient--one", {
    xPercent: -9,
    yPercent: 12,
    ease: "none",
    scrollTrigger: { trigger: ".hero", start: "top top", end: "bottom top", scrub: 1.2 },
  });

  gsap.to(".hero__title", {
    yPercent: 14,
    ease: "none",
    scrollTrigger: { trigger: ".hero", start: "top top", end: "bottom top", scrub: 1 },
  });
};

const initializeSplitReveals = () => {
  if (reducedMotion) return;

  document.querySelectorAll<HTMLElement>("[data-split-reveal]").forEach((element) => {
    SplitText.create(element, {
      type: "lines",
      mask: "lines",
      autoSplit: true,
      linesClass: "split-line",
      aria: "auto",
      onSplit(self) {
        return gsap.from(self.lines, {
          yPercent: 115,
          rotate: 1.5,
          duration: 1.05,
          stagger: 0.09,
          ease: "power4.out",
          scrollTrigger: {
            trigger: element,
            start: "top 84%",
            once: true,
          },
        });
      },
    });
  });
};

const initializeReveals = () => {
  if (reducedMotion) return;

  ScrollTrigger.batch(".reveal", {
    start: "top 88%",
    once: true,
    onEnter: (items) => {
      gsap.from(items, {
        y: 42,
        autoAlpha: 0,
        duration: 0.9,
        stagger: 0.1,
        ease: "power3.out",
        overwrite: true,
      });
    },
  });

  ScrollTrigger.batch(".reveal-row", {
    start: "top 91%",
    once: true,
    onEnter: (items) => {
      gsap.from(items, {
        y: 28,
        autoAlpha: 0,
        duration: 0.75,
        stagger: 0.07,
        ease: "power3.out",
        overwrite: true,
      });
    },
  });

  document.querySelectorAll<HTMLElement>(".reveal-media").forEach((wrapper) => {
    const image = wrapper.querySelector("img");
    gsap.from(wrapper, {
      clipPath: "inset(0 0 100% 0)",
      duration: 1.25,
      ease: "power4.inOut",
      scrollTrigger: { trigger: wrapper, start: "top 84%", once: true },
    });

    if (image) {
      gsap.to(image, {
        yPercent: 8,
        ease: "none",
        scrollTrigger: { trigger: wrapper, start: "top bottom", end: "bottom top", scrub: 1 },
      });
    }
  });
};

const initializePrepareTrack = () => {
  const wrapper = document.querySelector<HTMLElement>("[data-prepare-track]");
  const track = wrapper?.querySelector<HTMLElement>(".prepare__track");
  if (!wrapper || !track || reducedMotion) return;

  ScrollTrigger.matchMedia({
    "(min-width: 901px)": () => {
      const distance = () => Math.max(0, track.scrollWidth - window.innerWidth + 64);

      const tween = gsap.to(track, {
        x: () => -distance(),
        ease: "none",
        scrollTrigger: {
          trigger: wrapper,
          start: "top 14%",
          end: () => `+=${distance() + window.innerHeight * 0.55}`,
          pin: true,
          scrub: 1,
          anticipatePin: 1,
          invalidateOnRefresh: true,
        },
      });

      return () => tween.kill();
    },
  });
};

const initializeJourney = () => {
  const journey = document.querySelector<HTMLElement>("[data-journey]");
  const line = document.querySelector<HTMLElement>("[data-journey-line]");
  const dot = document.querySelector<HTMLElement>("[data-journey-dot]");
  const steps = gsap.utils.toArray<HTMLElement>("[data-journey-step]");
  if (!journey || !line || !dot || !steps.length) return;

  steps[0].classList.add("is-active");

  if (reducedMotion) {
    line.style.transform = "scaleY(1)";
    steps.forEach((step) => step.classList.add("is-active"));
    return;
  }

  gsap.to(line, {
    scaleY: 1,
    ease: "none",
    scrollTrigger: { trigger: journey, start: "top 65%", end: "bottom 45%", scrub: 0.6 },
  });

  gsap.to(dot, {
    y: () => Math.max(0, line.parentElement!.clientHeight),
    ease: "none",
    scrollTrigger: {
      trigger: journey,
      start: "top 65%",
      end: "bottom 45%",
      scrub: 0.6,
      invalidateOnRefresh: true,
    },
  });

  steps.forEach((step) => {
    ScrollTrigger.create({
      trigger: step,
      start: "top 62%",
      end: "bottom 38%",
      onToggle: (self) => step.classList.toggle("is-active", self.isActive),
    });
  });
};

type FrameState = {
  image: HTMLImageElement | null;
  loading: boolean;
};

const initializeScrollFilm = async () => {
  const section = document.querySelector<HTMLElement>("[data-scroll-film]");
  const canvas = document.querySelector<HTMLCanvasElement>("#scroll-frame-canvas");
  const status = document.querySelector<HTMLElement>("[data-frame-status]");
  const progressBar = document.querySelector<HTMLElement>("[data-film-progress]");
  const chapters = gsap.utils.toArray<HTMLElement>("[data-film-chapter]");
  const context = canvas?.getContext("2d", { alpha: false });
  const count = Number(section?.dataset.frameCount || 0);

  if (!section || !canvas || !context || !count) return;

  const frameStep = window.innerWidth < 700 ? 2 : 1;
  const states: FrameState[] = Array.from({ length: count }, () => ({ image: null, loading: false }));
  let activeFrame = -1;
  let activeChapter = 0;
  let loadedCount = 0;
  let renderRaf = 0;
  let targetFrame = 0;

  const framePath = (index: number) => `/frames/frame_${String(index + 1).padStart(4, "0")}.jpg`;

  const resizeCanvas = () => {
    const ratio = Math.min(window.devicePixelRatio || 1, 1.5);
    const width = Math.max(1, Math.round(canvas.clientWidth * ratio));
    const height = Math.max(1, Math.round(canvas.clientHeight * ratio));
    if (canvas.width === width && canvas.height === height) return;
    canvas.width = width;
    canvas.height = height;
    activeFrame = -1;
    drawFrame(targetFrame);
  };

  const nearestLoadedFrame = (requested: number) => {
    if (states[requested]?.image) return requested;
    for (let offset = 1; offset < count; offset += 1) {
      const before = requested - offset;
      const after = requested + offset;
      if (before >= 0 && states[before]?.image) return before;
      if (after < count && states[after]?.image) return after;
    }
    return -1;
  };

  const drawFrame = (requested: number) => {
    const index = nearestLoadedFrame(requested);
    if (index < 0 || index === activeFrame) return;
    const image = states[index].image;
    if (!image) return;

    const canvasRatio = canvas.width / canvas.height;
    const imageRatio = image.naturalWidth / image.naturalHeight;
    const width = imageRatio > canvasRatio ? canvas.height * imageRatio : canvas.width;
    const height = imageRatio > canvasRatio ? canvas.height : canvas.width / imageRatio;

    context.clearRect(0, 0, canvas.width, canvas.height);
    context.drawImage(image, (canvas.width - width) / 2, (canvas.height - height) / 2, width, height);
    activeFrame = index;
  };

  const queueRender = () => {
    if (renderRaf) return;
    renderRaf = requestAnimationFrame(() => {
      renderRaf = 0;
      drawFrame(targetFrame);
    });
  };

  const loadFrame = (index: number) =>
    new Promise<void>((resolve) => {
      const normalized = Math.min(count - 1, Math.max(0, Math.round(index / frameStep) * frameStep));
      const state = states[normalized];
      if (state.image || state.loading) {
        resolve();
        return;
      }

      state.loading = true;
      const image = new Image();
      image.decoding = "async";
      image.onload = () => {
        state.image = image;
        state.loading = false;
        loadedCount += 1;
        if (status) {
          const available = Math.ceil(count / frameStep);
          status.textContent = loadedCount >= available ? "Scroll to explore" : `Loading experience · ${Math.min(99, Math.round((loadedCount / available) * 100))}%`;
        }
        queueRender();
        resolve();
      };
      image.onerror = () => {
        state.loading = false;
        resolve();
      };
      image.src = framePath(normalized);
    });

  const preloadFrames = async () => {
    const indices = Array.from({ length: Math.ceil(count / frameStep) }, (_, index) => index * frameStep).filter((index) => index < count);
    let cursor = 1;
    const workers = Array.from({ length: finePointer ? 7 : 4 }, async () => {
      while (cursor < indices.length) {
        const index = indices[cursor++];
        await loadFrame(index);
      }
    });
    await Promise.all(workers);
  };

  const showChapter = (index: number) => {
    if (index === activeChapter || !chapters[index]) return;
    const previous = chapters[activeChapter];
    const next = chapters[index];
    activeChapter = index;

    if (reducedMotion) {
      previous?.classList.remove("is-active");
      next.classList.add("is-active");
      return;
    }

    gsap.killTweensOf([previous, next]);
    gsap.to(previous, {
      y: -30,
      autoAlpha: 0,
      duration: 0.36,
      ease: "power2.in",
      onComplete: () => previous?.classList.remove("is-active"),
    });
    next.classList.add("is-active");
    gsap.fromTo(next, { y: 36, autoAlpha: 0 }, { y: 0, autoAlpha: 1, duration: 0.58, ease: "power3.out" });
  };

  await loadFrame(0);
  resizeCanvas();
  drawFrame(0);

  if (reducedMotion) {
    section.style.height = "100svh";
    if (status) status.textContent = "Digital Banking · August 25, 2026";
    return;
  }

  ScrollTrigger.create({
    trigger: section,
    start: "top top",
    end: "bottom bottom",
    onUpdate: (self) => {
      targetFrame = Math.round(self.progress * (count - 1));
      targetFrame = Math.min(count - 1, Math.max(0, Math.round(targetFrame / frameStep) * frameStep));
      void loadFrame(targetFrame);
      queueRender();

      const chapter = Math.min(chapters.length - 1, Math.floor(self.progress * chapters.length));
      showChapter(chapter);
      if (progressBar) gsap.set(progressBar, { scaleX: self.progress });
    },
  });

  window.addEventListener("resize", resizeCanvas, { passive: true });
  void preloadFrames();
};

const initializeMarquee = () => {
  const marquee = document.querySelector<HTMLElement>(".same__marquee > div");
  if (!marquee || reducedMotion) return;

  gsap.to(marquee, {
    xPercent: -50,
    duration: 24,
    ease: "none",
    repeat: -1,
  });
};

const initializePageProgress = () => {
  const bar = document.querySelector<HTMLElement>(".page-progress span");
  if (!bar || reducedMotion) return;

  gsap.to(bar, {
    scaleX: 1,
    ease: "none",
    scrollTrigger: { start: 0, end: "max", scrub: 0.25 },
  });
};

const initializePointerDetails = () => {
  if (!finePointer || reducedMotion) return;

  const cursor = document.querySelector<HTMLElement>(".cursor-dot");
  if (cursor) {
    const moveX = gsap.quickTo(cursor, "x", { duration: 0.24, ease: "power3" });
    const moveY = gsap.quickTo(cursor, "y", { duration: 0.24, ease: "power3" });
    window.addEventListener("pointermove", (event) => {
      moveX(event.clientX);
      moveY(event.clientY);
      gsap.to(cursor, { autoAlpha: 1, duration: 0.2 });
    });
  }

  document.querySelectorAll<HTMLElement>(".magnetic").forEach((button) => {
    button.addEventListener("pointermove", (event) => {
      const rect = button.getBoundingClientRect();
      const x = event.clientX - rect.left - rect.width / 2;
      const y = event.clientY - rect.top - rect.height / 2;
      gsap.to(button, { x: x * 0.14, y: y * 0.18, duration: 0.35, ease: "power3.out" });
    });
    button.addEventListener("pointerleave", () => {
      gsap.to(button, { x: 0, y: 0, duration: 0.65, ease: "elastic.out(1, 0.4)" });
    });
  });
};

const initializeFaq = () => {
  const items = Array.from(document.querySelectorAll<HTMLDetailsElement>(".faq-item"));
  items.forEach((item) => {
    item.addEventListener("toggle", () => {
      if (!item.open) return;
      items.forEach((other) => {
        if (other !== item) other.open = false;
      });
    });
  });
};

const initializeTutorialDialog = () => {
  const dialog = document.querySelector<HTMLDialogElement>(".tutorial-dialog");
  const title = dialog?.querySelector<HTMLElement>("#tutorial-dialog-title");
  if (!dialog || !title) return;

  const close = () => dialog.close();

  document.querySelectorAll<HTMLButtonElement>("[data-tutorial]").forEach((button) => {
    button.addEventListener("click", () => {
      title.textContent = `${button.dataset.tutorial} is coming soon`;
      dialog.showModal();
    });
  });

  dialog.querySelectorAll<HTMLButtonElement>(".tutorial-dialog__close, .tutorial-dialog__button").forEach((button) => {
    button.addEventListener("click", close);
  });

  dialog.addEventListener("click", (event) => {
    if (event.target === dialog) close();
  });
};

const initializeClosingMotion = () => {
  if (reducedMotion) return;
  gsap.to(".closing__ring--one", {
    xPercent: 12,
    yPercent: 8,
    ease: "none",
    scrollTrigger: { trigger: ".closing", start: "top bottom", end: "bottom top", scrub: 1 },
  });
  gsap.to(".closing__ring--two", {
    xPercent: -10,
    yPercent: -9,
    ease: "none",
    scrollTrigger: { trigger: ".closing", start: "top bottom", end: "bottom top", scrub: 1 },
  });
};

const initialize = async () => {
  document.body.classList.add("is-loading");
  initializeSmoothScroll();
  initializeAnchorLinks();
  initializeHero();
  initializeSplitReveals();
  initializeReveals();
  initializePrepareTrack();
  initializeJourney();
  initializeMarquee();
  initializePageProgress();
  initializePointerDetails();
  initializeFaq();
  initializeTutorialDialog();
  initializeClosingMotion();
  await initializeScrollFilm();
  document.body.classList.remove("is-loading");
  ScrollTrigger.refresh();
};

void document.fonts.ready.then(initialize);
