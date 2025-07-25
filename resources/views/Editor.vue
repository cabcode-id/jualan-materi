<template>
    <button type="button" @click="">Set Content</button>
    <Editor :extensions="[]" ref="editorRef" />

    <button
        type="button"
        class="floating-btn"
        @click="floatingAction"
    >
    </button>
</template>

<script setup lang="ts">
import {Editor as EditorClass, Extensions} from "@tiptap/core";
import { Editor } from "novel-vue";
import { Color } from '@tiptap/extension-color'
import {ListItem} from '@tiptap/extension-list-item'
import TextStyle from '@tiptap/extension-text-style'
import {StarterKit} from "@tiptap/starter-kit";
import {Document} from "@tiptap/extension-document";
import {Dropcursor} from "@tiptap/extension-dropcursor";
import {Image} from "@tiptap/extension-image";
import {onMounted, type PropType, ref} from "vue";
const editorRef = ref<{
    editor: EditorClass,
    extension: Extensions
}>();

onMounted(() => {
    editorRef.value.editor.commands.setContent({
        type: "doc",
        content: [
            {
                type: "paragraph",
                content: [
                    {
                        type: "text",
                        text: "Example Text",
                    },
                ],
            },
        ],
    });
})

const floatingAction = () => {
    // Example: Insert a new paragraph at the end
    editorRef.value?.editor.chain().focus().insertContent({
        type: "paragraph",
        content: [
            { type: "text", text: "New block from floating button" },
        ],
    }).run();
};

</script>






<style>
:root{
    --novel-black: rgb(0 0 0);
    --novel-white: rgb(255 255 255);
    --novel-stone-50: rgb(250 250 249);
    --novel-stone-100: rgb(245 245 244);
    --novel-stone-200: rgb(231 229 228);
    --novel-stone-300: rgb(214 211 209);
    --novel-stone-400: rgb(168 162 158);
    --novel-stone-500: rgb(120 113 108);
    --novel-stone-600: rgb(87 83 78);
    --novel-stone-700: rgb(68 64 60);
    --novel-stone-800: rgb(41 37 36);
    --novel-stone-900: rgb(28 25 23);
    --novel-highlight-default: #ffffff;
    --novel-highlight-purple: #f6f3f8;
    --novel-highlight-red: #fdebeb;
    --novel-highlight-yellow: #fbf4a2;
    --novel-highlight-blue: #c1ecf9;
    --novel-highlight-green: #acf79f;
    --novel-highlight-orange: #faebdd;
    --novel-highlight-pink: #faf1f5;
    --novel-highlight-gray: #f1f1ef;
    --font-title: "Cal Sans", sans-serif
}
.dark-theme{
    --novel-black: rgb(255 255 255);
    --novel-white: rgb(25 25 25);
    --novel-stone-50: rgb(35 35 34);
    --novel-stone-100: rgb(41 37 36);
    --novel-stone-200: rgb(66 69 71);
    --novel-stone-300: rgb(112 118 123);
    --novel-stone-400: rgb(160 167 173);
    --novel-stone-500: rgb(193 199 204);
    --novel-stone-600: rgb(212 217 221);
    --novel-stone-700: rgb(229 232 235);
    --novel-stone-800: rgb(232 234 235);
    --novel-stone-900: rgb(240, 240, 241);
    --novel-highlight-default: #000000;
    --novel-highlight-purple: #3f2c4b;
    --novel-highlight-red: #5c1a1a;
    --novel-highlight-yellow: #5c4b1a;
    --novel-highlight-blue: #1a3d5c;
    --novel-highlight-green: #1a5c20;
    --novel-highlight-orange: #5c3a1a;
    --novel-highlight-pink: #5c1a3a;
    --novel-highlight-gray: #3a3a3a
}
@font-face{
    font-family:Cal Sans;
    src:local("Cal Sans"),url(CalSans-SemiBold.otf) format("otf")
}
*,:before,:after{
    box-sizing:border-box;
    border-width:0;
    border-style:solid;
    border-color:#e5e7eb
}
:before,:after{
    --tw-content: ""
}
html{
    line-height:1.5;
    -webkit-text-size-adjust:100%;
    -moz-tab-size:4;
    -o-tab-size:4;
    tab-size:4;
    font-family:ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,"Apple Color Emoji","Segoe UI Emoji",Segoe UI Symbol,"Noto Color Emoji";
    font-feature-settings:normal;
    font-variation-settings:normal
}
body{
    margin:0;
    line-height:inherit
}
hr{
    height:0;
    color:inherit;
    border-top-width:1px
}
abbr:where([title]){
    -webkit-text-decoration:underline dotted;
    text-decoration:underline dotted
}
h1,h2,h3,h4,h5,h6{
    font-size:inherit;
    font-weight:inherit
}
a{
    color:inherit;
    text-decoration:inherit
}
b,strong{
    font-weight:bolder
}
code,kbd,samp,pre{
    font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;
    font-size:1em
}
small{
    font-size:80%
}
sub,sup{
    font-size:75%;
    line-height:0;
    position:relative;
    vertical-align:baseline
}
sub{
    bottom:-.25em
}
sup{
    top:-.5em
}
table{
    text-indent:0;
    border-color:inherit;
    border-collapse:collapse
}
button,input,optgroup,select,textarea{
    font-family:inherit;
    font-feature-settings:inherit;
    font-variation-settings:inherit;
    font-size:100%;
    font-weight:inherit;
    line-height:inherit;
    color:inherit;
    margin:0;
    padding:0
}
button,select{
    text-transform:none
}
button,[type=button],[type=reset],[type=submit]{
    -webkit-appearance:button;
    background-image:none
}
:-moz-focusring{
    outline:auto
}
:-moz-ui-invalid{
    box-shadow:none
}
progress{
    vertical-align:baseline
}
::-webkit-inner-spin-button,::-webkit-outer-spin-button{
    height:auto
}
[type=search]{
    -webkit-appearance:textfield;
    outline-offset:-2px
}
::-webkit-search-decoration{
    -webkit-appearance:none
}
::-webkit-file-upload-button{
    -webkit-appearance:button;
    font:inherit
}
summary{
    display:list-item
}
blockquote,dl,dd,h1,h2,h3,h4,h5,h6,hr,figure,p,pre{
    margin:0
}
fieldset{
    margin:0;
    padding:0
}
legend{
    padding:0
}
ol,ul,menu{
    list-style:none;
    margin:0;
    padding:0
}
dialog{
    padding:0
}
textarea{
    resize:vertical
}
input::-moz-placeholder,textarea::-moz-placeholder{
    opacity:1;
    color:#9ca3af
}
input::placeholder,textarea::placeholder{
    opacity:1;
    color:#9ca3af
}
button,[role=button]{
    cursor:pointer
}
:disabled{
    cursor:default
}
img,svg,video,canvas,audio,iframe,embed,object{
    display:block;
    vertical-align:middle
}
img,video{
    max-width:100%;
    height:auto
}
[hidden]{
    display:none
}
*,:before,:after{
    --tw-border-spacing-x: 0;
    --tw-border-spacing-y: 0;
    --tw-translate-x: 0;
    --tw-translate-y: 0;
    --tw-rotate: 0;
    --tw-skew-x: 0;
    --tw-skew-y: 0;
    --tw-scale-x: 1;
    --tw-scale-y: 1;
    --tw-pan-x: ;
    --tw-pan-y: ;
    --tw-pinch-zoom: ;
    --tw-scroll-snap-strictness: proximity;
    --tw-gradient-from-position: ;
    --tw-gradient-via-position: ;
    --tw-gradient-to-position: ;
    --tw-ordinal: ;
    --tw-slashed-zero: ;
    --tw-numeric-figure: ;
    --tw-numeric-spacing: ;
    --tw-numeric-fraction: ;
    --tw-ring-inset: ;
    --tw-ring-offset-width: 0px;
    --tw-ring-offset-color: #fff;
    --tw-ring-color: rgb(59 130 246 / .5);
    --tw-ring-offset-shadow: 0 0 #0000;
    --tw-ring-shadow: 0 0 #0000;
    --tw-shadow: 0 0 #0000;
    --tw-shadow-colored: 0 0 #0000;
    --tw-blur: ;
    --tw-brightness: ;
    --tw-contrast: ;
    --tw-grayscale: ;
    --tw-hue-rotate: ;
    --tw-invert: ;
    --tw-saturate: ;
    --tw-sepia: ;
    --tw-drop-shadow: ;
    --tw-backdrop-blur: ;
    --tw-backdrop-brightness: ;
    --tw-backdrop-contrast: ;
    --tw-backdrop-grayscale: ;
    --tw-backdrop-hue-rotate: ;
    --tw-backdrop-invert: ;
    --tw-backdrop-opacity: ;
    --tw-backdrop-saturate: ;
    --tw-backdrop-sepia:
}
::backdrop{
    --tw-border-spacing-x: 0;
    --tw-border-spacing-y: 0;
    --tw-translate-x: 0;
    --tw-translate-y: 0;
    --tw-rotate: 0;
    --tw-skew-x: 0;
    --tw-skew-y: 0;
    --tw-scale-x: 1;
    --tw-scale-y: 1;
    --tw-pan-x: ;
    --tw-pan-y: ;
    --tw-pinch-zoom: ;
    --tw-scroll-snap-strictness: proximity;
    --tw-gradient-from-position: ;
    --tw-gradient-via-position: ;
    --tw-gradient-to-position: ;
    --tw-ordinal: ;
    --tw-slashed-zero: ;
    --tw-numeric-figure: ;
    --tw-numeric-spacing: ;
    --tw-numeric-fraction: ;
    --tw-ring-inset: ;
    --tw-ring-offset-width: 0px;
    --tw-ring-offset-color: #fff;
    --tw-ring-color: rgb(59 130 246 / .5);
    --tw-ring-offset-shadow: 0 0 #0000;
    --tw-ring-shadow: 0 0 #0000;
    --tw-shadow: 0 0 #0000;
    --tw-shadow-colored: 0 0 #0000;
    --tw-blur: ;
    --tw-brightness: ;
    --tw-contrast: ;
    --tw-grayscale: ;
    --tw-hue-rotate: ;
    --tw-invert: ;
    --tw-saturate: ;
    --tw-sepia: ;
    --tw-drop-shadow: ;
    --tw-backdrop-blur: ;
    --tw-backdrop-brightness: ;
    --tw-backdrop-contrast: ;
    --tw-backdrop-grayscale: ;
    --tw-backdrop-hue-rotate: ;
    --tw-backdrop-invert: ;
    --tw-backdrop-opacity: ;
    --tw-backdrop-saturate: ;
    --tw-backdrop-sepia:
}
.container{
    width:100%
}
@media (min-width: 640px){
    .container{
        max-width:640px
    }
}
@media (min-width: 768px){
    .container{
        max-width:768px
    }
}
@media (min-width: 1024px){
    .container{
        max-width:1024px
    }
}
@media (min-width: 1280px){
    .container{
        max-width:1280px
    }
}
@media (min-width: 1536px){
    .container{
        max-width:1536px
    }
}
.prose-lg{
    font-size:1.125rem;
    line-height:1.7777778
}
.prose-lg :where(p):not(:where([class~=not-prose] *)){
    margin-top:1.3333333em;
    margin-bottom:1.3333333em
}
.prose-lg :where([class~=lead]):not(:where([class~=not-prose] *)){
    font-size:1.2222222em;
    line-height:1.4545455;
    margin-top:1.0909091em;
    margin-bottom:1.0909091em
}
.prose-lg :where(blockquote):not(:where([class~=not-prose] *)){
    margin-top:1.6666667em;
    margin-bottom:1.6666667em;
    padding-left:1em
}
.prose-lg :where(h1):not(:where([class~=not-prose] *)){
    font-size:2.6666667em;
    margin-top:0;
    margin-bottom:.8333333em;
    line-height:1
}
.prose-lg :where(h2):not(:where([class~=not-prose] *)){
    font-size:1.6666667em;
    margin-top:1.8666667em;
    margin-bottom:1.0666667em;
    line-height:1.3333333
}
.prose-lg :where(h3):not(:where([class~=not-prose] *)){
    font-size:1.3333333em;
    margin-top:1.6666667em;
    margin-bottom:.6666667em;
    line-height:1.5
}
.prose-lg :where(h4):not(:where([class~=not-prose] *)){
    margin-top:1.7777778em;
    margin-bottom:.4444444em;
    line-height:1.5555556
}
.prose-lg :where(img):not(:where([class~=not-prose] *)){
    margin-top:1.7777778em;
    margin-bottom:1.7777778em
}
.prose-lg :where(video):not(:where([class~=not-prose] *)){
    margin-top:1.7777778em;
    margin-bottom:1.7777778em
}
.prose-lg :where(figure):not(:where([class~=not-prose] *)){
    margin-top:1.7777778em;
    margin-bottom:1.7777778em
}
.prose-lg :where(figure>*):not(:where([class~=not-prose] *)){
    margin-top:0;
    margin-bottom:0
}
.prose-lg :where(figcaption):not(:where([class~=not-prose] *)){
    font-size:.8888889em;
    line-height:1.5;
    margin-top:1em
}
.prose-lg :where(code):not(:where([class~=not-prose] *)){
    font-size:.8888889em
}
.prose-lg :where(h2 code):not(:where([class~=not-prose] *)){
    font-size:.8666667em
}
.prose-lg :where(h3 code):not(:where([class~=not-prose] *)){
    font-size:.875em
}
.prose-lg :where(pre):not(:where([class~=not-prose] *)){
    font-size:.8888889em;
    line-height:1.75;
    margin-top:2em;
    margin-bottom:2em;
    border-radius:.375rem;
    padding:1em 1.5em
}
.prose-lg :where(ol):not(:where([class~=not-prose] *)){
    margin-top:1.3333333em;
    margin-bottom:1.3333333em;
    padding-left:1.5555556em
}
.prose-lg :where(ul):not(:where([class~=not-prose] *)){
    margin-top:1.3333333em;
    margin-bottom:1.3333333em;
    padding-left:1.5555556em
}
.prose-lg :where(li):not(:where([class~=not-prose] *)){
    margin-top:.6666667em;
    margin-bottom:.6666667em
}
.prose-lg :where(ol>li):not(:where([class~=not-prose] *)){
    padding-left:.4444444em
}
.prose-lg :where(ul>li):not(:where([class~=not-prose] *)){
    padding-left:.4444444em
}
.prose-lg :where(.prose-lg>ul>li p):not(:where([class~=not-prose] *)){
    margin-top:.8888889em;
    margin-bottom:.8888889em
}
.prose-lg :where(.prose-lg>ul>li>*:first-child):not(:where([class~=not-prose] *)){
    margin-top:1.3333333em
}
.prose-lg :where(.prose-lg>ul>li>*:last-child):not(:where([class~=not-prose] *)){
    margin-bottom:1.3333333em
}
.prose-lg :where(.prose-lg>ol>li>*:first-child):not(:where([class~=not-prose] *)){
    margin-top:1.3333333em
}
.prose-lg :where(.prose-lg>ol>li>*:last-child):not(:where([class~=not-prose] *)){
    margin-bottom:1.3333333em
}
.prose-lg :where(ul ul,ul ol,ol ul,ol ol):not(:where([class~=not-prose] *)){
    margin-top:.8888889em;
    margin-bottom:.8888889em
}
.prose-lg :where(hr):not(:where([class~=not-prose] *)){
    margin-top:3.1111111em;
    margin-bottom:3.1111111em
}
.prose-lg :where(hr+*):not(:where([class~=not-prose] *)){
    margin-top:0
}
.prose-lg :where(h2+*):not(:where([class~=not-prose] *)){
    margin-top:0
}
.prose-lg :where(h3+*):not(:where([class~=not-prose] *)){
    margin-top:0
}
.prose-lg :where(h4+*):not(:where([class~=not-prose] *)){
    margin-top:0
}
.prose-lg :where(table):not(:where([class~=not-prose] *)){
    font-size:.8888889em;
    line-height:1.5
}
.prose-lg :where(thead th):not(:where([class~=not-prose] *)){
    padding-right:.75em;
    padding-bottom:.75em;
    padding-left:.75em
}
.prose-lg :where(thead th:first-child):not(:where([class~=not-prose] *)){
    padding-left:0
}
.prose-lg :where(thead th:last-child):not(:where([class~=not-prose] *)){
    padding-right:0
}
.prose-lg :where(tbody td,tfoot td):not(:where([class~=not-prose] *)){
    padding:.75em
}
.prose-lg :where(tbody td:first-child,tfoot td:first-child):not(:where([class~=not-prose] *)){
    padding-left:0
}
.prose-lg :where(tbody td:last-child,tfoot td:last-child):not(:where([class~=not-prose] *)){
    padding-right:0
}
.prose-lg :where(.prose-lg>:first-child):not(:where([class~=not-prose] *)){
    margin-top:0
}
.prose-lg :where(.prose-lg>:last-child):not(:where([class~=not-prose] *)){
    margin-bottom:0
}
.prose-stone{
    --tw-prose-body: #44403c;
    --tw-prose-headings: #1c1917;
    --tw-prose-lead: #57534e;
    --tw-prose-links: #1c1917;
    --tw-prose-bold: #1c1917;
    --tw-prose-counters: #78716c;
    --tw-prose-bullets: #d6d3d1;
    --tw-prose-hr: #e7e5e4;
    --tw-prose-quotes: #1c1917;
    --tw-prose-quote-borders: #e7e5e4;
    --tw-prose-captions: #78716c;
    --tw-prose-code: #1c1917;
    --tw-prose-pre-code: #e7e5e4;
    --tw-prose-pre-bg: #292524;
    --tw-prose-th-borders: #d6d3d1;
    --tw-prose-td-borders: #e7e5e4;
    --tw-prose-invert-body: #d6d3d1;
    --tw-prose-invert-headings: #fff;
    --tw-prose-invert-lead: #a8a29e;
    --tw-prose-invert-links: #fff;
    --tw-prose-invert-bold: #fff;
    --tw-prose-invert-counters: #a8a29e;
    --tw-prose-invert-bullets: #57534e;
    --tw-prose-invert-hr: #44403c;
    --tw-prose-invert-quotes: #f5f5f4;
    --tw-prose-invert-quote-borders: #44403c;
    --tw-prose-invert-captions: #a8a29e;
    --tw-prose-invert-code: #fff;
    --tw-prose-invert-pre-code: #d6d3d1;
    --tw-prose-invert-pre-bg: rgb(0 0 0 / 50%);
    --tw-prose-invert-th-borders: #57534e;
    --tw-prose-invert-td-borders: #44403c
}
.fixed{
    position:fixed
}
.absolute{
    position:absolute
}
.relative{
    position:relative
}
.top-full{
    top:100%
}
.z-50{
    z-index:50
}
.z-\[99999\]{
    z-index:99999
}
.mx-auto{
    margin-left:auto;
    margin-right:auto
}
.my-1{
    margin-top:.25rem;
    margin-bottom:.25rem
}
.my-4{
    margin-top:1rem;
    margin-bottom:1rem
}
.-mb-2{
    margin-bottom:-.5rem
}
.-mt-2{
    margin-top:-.5rem
}
.mb-1{
    margin-bottom:.25rem
}
.mb-6{
    margin-bottom:1.5rem
}
.mt-1{
    margin-top:.25rem
}
.mt-2{
    margin-top:.5rem
}
.mt-4{
    margin-top:1rem
}
.mt-8{
    margin-top:2rem
}
.flex{
    display:flex
}
.h-10{
    height:2.5rem
}
.h-3{
    height:.75rem
}
.h-4{
    height:1rem
}
.h-auto{
    height:auto
}
.h-full{
    height:100%
}
.max-h-80{
    max-height:20rem
}
.max-h-\[330px\]{
    max-height:330px
}
.min-h-\[500px\]{
    min-height:500px
}
.w-10{
    width:2.5rem
}
.w-3{
    width:.75rem
}
.w-4{
    width:1rem
}
.w-48{
    width:12rem
}
.w-60{
    width:15rem
}
.w-72{
    width:18rem
}
.w-fit{
    width:-moz-fit-content;
    width:fit-content
}
.w-full{
    width:100%
}
.max-w-full{
    max-width:100%
}
.max-w-screen-lg{
    max-width:1024px
}
.flex-1{
    flex:1 1 0%
}
@keyframes spin{
    to{
        transform:rotate(360deg)
    }
}
.animate-spin{
    animation:spin 1s linear infinite
}
.cursor-pointer{
    cursor:pointer
}
.list-outside{
    list-style-position:outside
}
.list-decimal{
    list-style-type:decimal
}
.list-disc{
    list-style-type:disc
}
.flex-col{
    flex-direction:column
}
.items-start{
    align-items:flex-start
}
.items-center{
    align-items:center
}
.justify-center{
    justify-content:center
}
.justify-between{
    justify-content:space-between
}
.gap-1{
    gap:.25rem
}
.space-x-2>:not([hidden])~:not([hidden]){
    --tw-space-x-reverse: 0;
    margin-right:calc(.5rem * var(--tw-space-x-reverse));
    margin-left:calc(.5rem * calc(1 - var(--tw-space-x-reverse)))
}
.divide-x>:not([hidden])~:not([hidden]){
    --tw-divide-x-reverse: 0;
    border-right-width:calc(1px * var(--tw-divide-x-reverse));
    border-left-width:calc(1px * calc(1 - var(--tw-divide-x-reverse)))
}
.divide-stone-200>:not([hidden])~:not([hidden]){
    --tw-divide-opacity: 1;
    border-color:rgb(231 229 228 / var(--tw-divide-opacity))
}
.overflow-hidden{
    overflow:hidden
}
.overflow-y-auto{
    overflow-y:auto
}
.whitespace-nowrap{
    white-space:nowrap
}
.rounded{
    border-radius:.25rem
}
.rounded-lg{
    border-radius:.5rem
}
.rounded-md{
    border-radius:.375rem
}
.rounded-sm{
    border-radius:.125rem
}
.border{
    border-width:1px
}
.border-l-4{
    border-left-width:4px
}
.border-t{
    border-top-width:1px
}
.border-stone-200{
    --tw-border-opacity: 1;
    border-color:rgb(231 229 228 / var(--tw-border-opacity))
}
.border-stone-300{
    --tw-border-opacity: 1;
    border-color:rgb(214 211 209 / var(--tw-border-opacity))
}
.border-stone-700{
    --tw-border-opacity: 1;
    border-color:rgb(68 64 60 / var(--tw-border-opacity))
}
.bg-stone-100{
    --tw-bg-opacity: 1;
    background-color:rgb(245 245 244 / var(--tw-bg-opacity))
}
.bg-stone-200{
    --tw-bg-opacity: 1;
    background-color:rgb(231 229 228 / var(--tw-bg-opacity))
}
.bg-white{
    --tw-bg-opacity: 1;
    background-color:rgb(255 255 255 / var(--tw-bg-opacity))
}
.fill-stone-600{
    fill:#57534e
}
.p-1{
    padding:.25rem
}
.p-12{
    padding:3rem
}
.p-2{
    padding:.5rem
}
.p-5{
    padding:1.25rem
}
.px-1{
    padding-left:.25rem;
    padding-right:.25rem
}
.px-1\.5{
    padding-left:.375rem;
    padding-right:.375rem
}
.px-2{
    padding-left:.5rem;
    padding-right:.5rem
}
.px-3{
    padding-left:.75rem;
    padding-right:.75rem
}
.px-8{
    padding-left:2rem;
    padding-right:2rem
}
.py-1{
    padding-top:.25rem;
    padding-bottom:.25rem
}
.py-1\.5{
    padding-top:.375rem;
    padding-bottom:.375rem
}
.py-2{
    padding-top:.5rem;
    padding-bottom:.5rem
}
.py-px{
    padding-top:1px;
    padding-bottom:1px
}
.pl-2{
    padding-left:.5rem
}
.text-left{
    text-align:left
}
.font-mono{
    font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace
}
.text-base{
    font-size:1rem;
    line-height:1.5rem
}
.text-sm{
    font-size:.875rem;
    line-height:1.25rem
}
.text-xs{
    font-size:.75rem;
    line-height:1rem
}
.font-medium{
    font-weight:500
}
.italic{
    font-style:italic
}
.leading-3{
    line-height:.75rem
}
.leading-normal{
    line-height:1.5
}
.text-blue-500{
    --tw-text-opacity: 1;
    color:rgb(59 130 246 / var(--tw-text-opacity))
}
.text-red-600{
    --tw-text-opacity: 1;
    color:rgb(220 38 38 / var(--tw-text-opacity))
}
.text-stone-200{
    --tw-text-opacity: 1;
    color:rgb(231 229 228 / var(--tw-text-opacity))
}
.text-stone-400{
    --tw-text-opacity: 1;
    color:rgb(168 162 158 / var(--tw-text-opacity))
}
.text-stone-500{
    --tw-text-opacity: 1;
    color:rgb(120 113 108 / var(--tw-text-opacity))
}
.text-stone-600{
    --tw-text-opacity: 1;
    color:rgb(87 83 78 / var(--tw-text-opacity))
}
.text-stone-800{
    --tw-text-opacity: 1;
    color:rgb(41 37 36 / var(--tw-text-opacity))
}
.text-stone-900{
    --tw-text-opacity: 1;
    color:rgb(28 25 23 / var(--tw-text-opacity))
}
.underline{
    text-decoration-line:underline
}
.decoration-stone-400{
    text-decoration-color:#a8a29e
}
.underline-offset-4{
    text-underline-offset:4px
}
.underline-offset-\[3px\]{
    text-underline-offset:3px
}
.shadow-md{
    --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / .1), 0 2px 4px -2px rgb(0 0 0 / .1);
    --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);
    box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)
}
.shadow-xl{
    --tw-shadow: 0 20px 25px -5px rgb(0 0 0 / .1), 0 8px 10px -6px rgb(0 0 0 / .1);
    --tw-shadow-colored: 0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color);
    box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)
}
.outline-none{
    outline:2px solid transparent;
    outline-offset:2px
}
.filter{
    filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)
}
.transition-all{
    transition-property:all;
    transition-timing-function:cubic-bezier(.4,0,.2,1);
    transition-duration:.15s
}
.transition-colors{
    transition-property:color,background-color,border-color,text-decoration-color,fill,stroke;
    transition-timing-function:cubic-bezier(.4,0,.2,1);
    transition-duration:.15s
}
@keyframes enter{
    0%{
        opacity:var(--tw-enter-opacity, 1);
        transform:translate3d(var(--tw-enter-translate-x, 0),var(--tw-enter-translate-y, 0),0) scale3d(var(--tw-enter-scale, 1),var(--tw-enter-scale, 1),var(--tw-enter-scale, 1)) rotate(var(--tw-enter-rotate, 0))
    }
}
@keyframes exit{
    to{
        opacity:var(--tw-exit-opacity, 1);
        transform:translate3d(var(--tw-exit-translate-x, 0),var(--tw-exit-translate-y, 0),0) scale3d(var(--tw-exit-scale, 1),var(--tw-exit-scale, 1),var(--tw-exit-scale, 1)) rotate(var(--tw-exit-rotate, 0))
    }
}
.animate-in{
    animation-name:enter;
    animation-duration:.15s;
    --tw-enter-opacity: initial;
    --tw-enter-scale: initial;
    --tw-enter-rotate: initial;
    --tw-enter-translate-x: initial;
    --tw-enter-translate-y: initial
}
.fade-in{
    --tw-enter-opacity: 0
}
.slide-in-from-top-1{
    --tw-enter-translate-y: -.25rem
}
.paused{
    animation-play-state:paused
}
@media (prefers-color-scheme: dark){
    .dark\:prose-invert{
        --tw-prose-body: var(--tw-prose-invert-body);
        --tw-prose-headings: var(--tw-prose-invert-headings);
        --tw-prose-lead: var(--tw-prose-invert-lead);
        --tw-prose-links: var(--tw-prose-invert-links);
        --tw-prose-bold: var(--tw-prose-invert-bold);
        --tw-prose-counters: var(--tw-prose-invert-counters);
        --tw-prose-bullets: var(--tw-prose-invert-bullets);
        --tw-prose-hr: var(--tw-prose-invert-hr);
        --tw-prose-quotes: var(--tw-prose-invert-quotes);
        --tw-prose-quote-borders: var(--tw-prose-invert-quote-borders);
        --tw-prose-captions: var(--tw-prose-invert-captions);
        --tw-prose-code: var(--tw-prose-invert-code);
        --tw-prose-pre-code: var(--tw-prose-invert-pre-code);
        --tw-prose-pre-bg: var(--tw-prose-invert-pre-bg);
        --tw-prose-th-borders: var(--tw-prose-invert-th-borders);
        --tw-prose-td-borders: var(--tw-prose-invert-td-borders)
    }
}
.hover\:bg-red-100:hover{
    --tw-bg-opacity: 1;
    background-color:rgb(254 226 226 / var(--tw-bg-opacity))
}
.hover\:bg-stone-100:hover{
    --tw-bg-opacity: 1;
    background-color:rgb(245 245 244 / var(--tw-bg-opacity))
}
.hover\:text-stone-600:hover{
    --tw-text-opacity: 1;
    color:rgb(87 83 78 / var(--tw-text-opacity))
}
.focus\:outline-none:focus{
    outline:2px solid transparent;
    outline-offset:2px
}
.active\:bg-stone-200:active{
    --tw-bg-opacity: 1;
    background-color:rgb(231 229 228 / var(--tw-bg-opacity))
}
@media (prefers-color-scheme: dark){
    .dark\:hover\:bg-red-800:hover{
        --tw-bg-opacity: 1;
        background-color:rgb(153 27 27 / var(--tw-bg-opacity))
    }
}
@media (min-width: 640px){
    .sm\:mb-\[calc\(20vh\)\]{
        margin-bottom:20vh
    }
    .sm\:rounded-lg{
        border-radius:.5rem
    }
    .sm\:border{
        border-width:1px
    }
    .sm\:px-12{
        padding-left:3rem;
        padding-right:3rem
    }
    .sm\:shadow-lg{
        --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / .1), 0 4px 6px -4px rgb(0 0 0 / .1);
        --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);
        box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)
    }
}
.ProseMirror .is-editor-empty:first-child:before{
    content:attr(data-placeholder);
    float:left;
    color:var(--novel-stone-400);
    pointer-events:none;
    height:0
}
.ProseMirror .is-empty:before{
    content:attr(data-placeholder);
    float:left;
    color:var(--novel-stone-400);
    pointer-events:none;
    height:0
}
.ProseMirror img{
    transition:filter .1s ease-in-out
}
.ProseMirror img:hover{
    cursor:pointer;
    filter:brightness(90%)
}
.ProseMirror img.ProseMirror-selectednode{
    outline:3px solid #5abbf7;
    filter:brightness(90%)
}
.img-placeholder{
    position:relative
}
.img-placeholder:before{
    content:"";
    box-sizing:border-box;
    position:absolute;
    top:50%;
    left:50%;
    width:36px;
    height:36px;
    border-radius:50%;
    border:3px solid var(--novel-stone-200);
    border-top-color:var(--novel-stone-800);
    animation:spinning .6s linear infinite
}
@keyframes spinning{
    to{
        transform:rotate(360deg)
    }
}
ul[data-type=taskList] li>label{
    margin-right:.2rem;
    -webkit-user-select:none;
    -moz-user-select:none;
    user-select:none
}
@media screen and (max-width: 768px){
    ul[data-type=taskList] li>label{
        margin-right:.5rem
    }
}
ul[data-type=taskList] li>label input[type=checkbox]{
    -webkit-appearance:none;
    -moz-appearance:none;
    appearance:none;
    background-color:var(--novel-white);
    margin:0;
    cursor:pointer;
    width:1.2em;
    height:1.2em;
    position:relative;
    top:5px;
    border:2px solid var(--novel-stone-900);
    margin-right:.3rem;
    display:grid;
    place-content:center
}
ul[data-type=taskList] li>label input[type=checkbox]:hover{
    background-color:var(--novel-stone-50)
}
ul[data-type=taskList] li>label input[type=checkbox]:active{
    background-color:var(--novel-stone-200)
}
ul[data-type=taskList] li>label input[type=checkbox]:before{
    content:"";
    width:.65em;
    height:.65em;
    transform:scale(0);
    transition:.12s transform ease-in-out;
    box-shadow:inset 1em 1em;
    transform-origin:center;
    -webkit-clip-path:polygon(14% 44%,0 65%,50% 100%,100% 16%,80% 0%,43% 62%);
    clip-path:polygon(14% 44%,0 65%,50% 100%,100% 16%,80% 0%,43% 62%)
}
ul[data-type=taskList] li>label input[type=checkbox]:checked:before{
    transform:scale(1)
}
ul[data-type=taskList] li[data-checked=true]>div>p{
    color:var(--novel-stone-400);
    text-decoration:line-through;
    text-decoration-thickness:2px
}

</style>
