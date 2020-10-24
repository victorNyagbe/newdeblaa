<template>
    <div>
        <form>
            <div class="form-row">
                <div class="col-4">
                    <input type="text" name="number" id="number" v-model="number" placeholder="Téléphone" class="form-control" required autocomplete="off" autofocus>
                </div>
                <div class="col-8">
                    <input type="text" name="name" id="name" v-model="name" placeholder="Noms et prénoms" class="form-control" required autocomplete="off">
                </div>
            </div>
            <div class="form-group mt-3 d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-green btn-sm white-text" @click="addContact">Enregistrer</button>
                <a :href="'message'" class="btn btn-blue white-text btn-sm">Message</a>
            </div>
        </form>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                number: '',
                name: ''
            }
        },

        methods: {
            addContact() {
                axios.post("contacts-store", {
                    name: this.name,
                    number: this.number
                }).then(response => this.$emit('contact-added', response))
                .catch(error => console.log(error))
            }
        }
    }
</script>