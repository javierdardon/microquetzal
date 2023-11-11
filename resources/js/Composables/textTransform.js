
export function useTextTransform() {
    const slugify = ( text ) => {
      return text.toLowerCase()
        .replace(/ /g, "-")
        .replace(/[^\w-]+/g, "");
    }
    return { slugify }
  }
