<template>
    <div class="relative">
        <heading class="mb-3">Push Notifications</heading>

        <card class="overflow-hidden">
            <div>
                <div style="text-align: center; margin-top:20px; color:green;" v-show="recipients">{{ recipients }}</div>
                <div style="text-align: center; margin-top:20px; color:red;">
                    <div v-if="errors.length">
                        <div v-for="error in errors">{{ error }}</div>
                    </div>
                </div>
                <div class="flex border-b border-40">
                    <div class="w-1/5 py-6 px-8">
                        <label class="inline-block text-80 pt-2 leading-tight" for="heading">Heading</label>
                    </div>
                    <div class="py-6 px-8 w-1/2">
                        <input v-model="heading" id="heading" type="text" class="w-full form-control form-input form-input-bordered">
                    </div>
                </div>
                <div class="flex border-b border-40">
                    <div class="w-1/5 py-6 px-8">
                        <label class="inline-block text-80 pt-2 leading-tight" for="text">Text</label>
                    </div>
                    <div class="py-6 px-8 w-1/2">
                        <textarea
                                v-model="text"
                                :id="text"
                                :class="{ 'border-danger': hasError }"
                                class="w-full form-control form-input form-input-bordered py-3 h-auto"
                        ></textarea>

                        <p v-if="hasError" class="text-xs mt-2 text-danger">{{ firstError }}</p>
                    </div>
                </div>
                <div class="flex border-b border-40">
                    <div class="w-1/5 py-6 px-8">
                        <label class="inline-block text-80 pt-2 leading-tight" for="url">Url</label>
                    </div>
                    <div class="py-6 px-8 w-1/2">
                        <input v-model="url" id="url" type="text" class="w-full form-control form-input form-input-bordered">
                    </div>
                </div>
            </div>
            <div class="bg-30 flex px-8 py-4">
                <button class="btn btn-default btn-primary inline-flex items-center relative" @click="sendPushNotification">Send</button>
            </div>
        </card>
    </div>
</template>

<script>
    import { Errors } from 'laravel-nova'

    export default {
        data: () => ({
            heading: "",
            text: "",
            url: "",
            errors: [],
            recipients: 0,
            formErrors: new Errors(),
        }),

        computed: {
            hasError() {
                return this.formErrors.has('text');
            },

            firstError() {
                if (this.hasError) {
                    return this.formErrors.first('text')
                }
            },
        },

        methods: {
            sendPushNotification() {
                this.formErrors = new Errors();

                Nova.request().post('/nova-vendor/nova-push-notification/send', {
                    heading: this.heading,
                    text: this.text,
                    url: this.url
                }).then(response => {
                    if (response.data.id && response.data.recipients > 0) {
                        this.recipients = 'Push Notifications Sent Successfully to ' + response.data.recipients + ' Recipients';
                        this.heading = '';
                        this.text = '';
                        this.url = '';
                    }
                }).catch(e => {
                    this.formErrors = new Errors(e.response.data.errors)
                });
            },
        },
    }
</script>