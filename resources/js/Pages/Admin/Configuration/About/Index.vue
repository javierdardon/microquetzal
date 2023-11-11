<script setup>
import { reactive, ref } from "vue";
import { Head, router, usePage } from "@inertiajs/vue3";
// languaje
import 'froala-editor/js/languages/es.js';

const page = usePage();

const props = defineProps({
    about: Object,
});

const form = reactive({
    body: props.about.body,
});

function submit() {
    router.post("/admin/configurations/about-update", form, {
        forceFormData: true,
    });
}


const config = ref({
    // Image upload request
    imageUploadURL: '/admin/froala-upload',
    imageUploadParam: 'image',
    imageUploadParams: {
    froala: 'true',
    _token: page.props.csrf_token,
    path: 'about/',
    },
    imageUploadMethod: 'post',

    // Image delete request
    events: {
      "image.removed": function ( image ) {
        let data = {
          image: image[0].attributes[0].nodeValue,
          _token: page.props.csrf_token,
        }

        fetch('/admin/froala-remove', {
          method: "POST",
          body: JSON.stringify(data),
          headers: {"Content-type": "application/json; charset=UTF-8"}
        })
      }
    },

    // Other config
    language: 'es',
    language: "es",
    formStyles: { class1: "mb-10" },

    toolbarButtons: [
        "bold",
        "italic",
        "underline",
        "strikeThrough",
        "subscript",
        "superscript",

        "|",

        "fontFamily",
        "fontSize",
        "textColor",
        "backgroundColor",
        "color",
        "inlineStyle",
        "paragraphStyle",

        "|",

        "paragraphFormat",
        "align",
        "formatOL",
        "formatUL",
        "outdent",
        "indent",
        "quote",
        "-",
        "insertLink",
        "insertImage",
        "insertTable",
        "insertVideo",
        "|",

        "emoticons",
        "specialCharacters",
        "insertHR",
        "selectAll",
        "clearFormatting",

        "|",

        "undo",
        "redo",
        "trackChanges",
        "markdown",
    ],
    videoResponsive: true,
    pluginsEnabled: [
        "video",
        "align",
        "colors",
        "emoticons",
        "fontAwesome",
        "fontFamily",
        "fontSize",
        "image",
        "imageManager",
        "imageTUI",
        "inlineClass",
        "inlineStyle",
        "lineBreaker",
        "lineHeight",
        "link",
        "lists",
        "markdown",
        "paragraphFormat",
        "paragraphStyle",
        "quote",
        "specialCharacters",
        "track_changes",
        "table",
        "wordPaste",
    ],
});

const useGoBack = useBack;
</script>

<template>
    <Head title='Editar la información de la pagina "Nosotros"' />

    <AuthenticatedLayout>
        <div class="flex justify-between items-center mb-5">
            <h1 class="dark:text-white text-2xl font-bold">Modifica la pagina "Nosotros"</h1>
            <ButtonNavigator
              href=""
              @click="useGoBack"
              text="Volver"
              type="button"
            />
        </div>
        <FormKit type="form" submit-label="Guardar" @submit="submit">
            <froala
                id="edit"
                :tag="'textarea'"
                :config="config"
                v-model:value="form.body"
            ></froala>
        </FormKit>
    </AuthenticatedLayout>
</template>
