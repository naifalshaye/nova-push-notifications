<template>
    <div>
        <heading class="mb-6">Push Notifications</heading>

        <card class="flex flex-col items-center justify-center" style="min-height: 300px">
            <div>
                <div style="text-align: center; margin-top:20px; color:green;" v-show="recipients">{{ recipients }}</div>
                <div style="text-align: center; margin-top:20px; color:red;">
                    <div v-if="errors.length">
                        <div v-for="error in errors">{{ error }}</div>
                    </div>
                </div>
                <div class="flex border-b border-40">
                    <div class="w-2/8 px-22 py-8">
                        <label class="inline-block" for="heading">Heading</label>
                    </div>
                    <div class="w-2/2 px-8 py-6">
                        <input v-model="heading" id="heading" type="text" class="w-full form-control form-input form-input-bordered" style="width:280px !important; margin-left:30px;">
                    </div>
                </div>
                <div class="flex border-b border-40">
                    <div class="w-2/2 px-8 py-6">
                        <label class="inline-block" for="text">Text</label>
                    </div>
                    <div class="w-2/2 px-8 py-6">
                        <textarea v-model="text" id="text" class="w-full form-control form-input form-input-bordered" style="height: 140px;" cols="30"></textarea>
                    </div>
                </div>
                <div class="flex border-b border-40">
                    <div class="w-2/8 px-22 py-8">
                        <label class="inline-block" for="url">Url</label>
                    </div>
                    <div class="w-2/2 px-8 py-6">
                        <input v-model="url" id="url" type="text" class="w-full form-control form-input form-input-bordered" style="width:280px !important; margin-left:30px;">
                    </div>
                </div>
            </div>
            <div class="px-4 py-2" align="center">
                <button class="ml-auto btn btn-default btn-primary mr-3" @click="sendSMS">Send</button>
            </div>
        </card>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                heading: "",
                text: "",
                url: "",
                errors: [],
                recipients: 0
            }
        },
        mounted() {

        },
        methods: {
            sendSMS() {
                Nova.request().post('/nova-vendor/nova-push-notification/send', {
                    heading: this.heading,
                    text: this.text,
                    url: this.url
                }).then(response => {
                    if (response.data.errors) {
                        this.errors = response.data.errors;
                    } else if (response.data.id && response.data.recipients > 0) {
                        this.recipients = 'Push Notifications Sent Successfully to ' + response.data.recipients + ' Recipients';
                        this.heading = '';
                        this.text = '';
                        this.url = '';
                    }
                });
            },
        },
    }
</script>