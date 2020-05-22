<template>
    <fieldset>
        <legend>{{ title }}</legend>

        <label class="label" v-bind:for="inputID + '_x'">Latitude</label>
        <input type="number" name="corner" step="0.1" v-bind:id="inputID + '_x'" required="" v-model="coords.x">

        <label class="label" v-bind:for="inputID + '_y'">Longitude</label>
        <input type="number" name="corner" step="0.1" v-bind:id="inputID +'_y'" required="" v-model="coords.y">
    </fieldset>
</template>

<script>
    export default {
        name: "Point",
        props: {
            title: String,
            inputID: String,
        },
        data: function() {
            return {
                "coords": {
                    "x": 0,
                    "y": 0
                }
            }
        }
    }
</script>

<style scoped>
    fieldset {
        display: inline-block;
    }

    label {
        margin: 0 4px 0 8px;
    }
</style>