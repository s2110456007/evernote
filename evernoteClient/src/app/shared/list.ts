import { Note } from "./note";
import { User } from "./user";

export class List {
    constructor(
        public id:number,
        public name:string,
        public created_by:number,
        public creator:User,
        public notes?:Note[]
    ){}
}
