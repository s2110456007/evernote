export class User {
    constructor(
        public id:number,
        public first_name:string,
        public last_name:string,
        public email:string,
        public email_verified_at?:Date,
        public profile_image?:string
    ){}
}