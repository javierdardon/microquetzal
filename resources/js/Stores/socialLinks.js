import { defineStore } from "pinia";

export const useSocialLinks = defineStore("socialLink", () => {
    const SocialLinksList = ref({
        facebook: {
            icon: "logos:facebook",
            link: "",
        },
        whatsapp: {
            icon: "logos:whatsapp-icon",
            link: "",
        },
        gmail: {
            icon: "logos:google-gmail",
            link: "",
        },
        twitter: {
            icon: "skill-icons:twitter",
            link: "",
        },
        instagram: {
            icon: "skill-icons:instagram",
            link: "",
        },
        tikTok: {
            icon: "logos:tiktok-icon",
            link: "",
        },
    });

    const updateSocialLinkList = (apiSocialLinksList) => {
        for (const property in apiSocialLinksList) {
            for (const social  in SocialLinksList.value) {
                if (property === social ) {
                    const text = apiSocialLinksList[property];
                    SocialLinksList.value[social].link = text;
                }
            }
        }
    };

    return { updateSocialLinkList, SocialLinksList };
});
