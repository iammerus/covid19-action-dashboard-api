import mongoose from "mongoose";

export interface IHistory extends mongoose.Document {
  countryId: string;
  recovered: number;
  deaths: number;
  active: number;
  confirmed: number;
  updateTime: number;
}

export const HistorySchema = new mongoose.Schema({
  countryId: { type: String, required: true },
  name: { type: String, required: true },
  recovered: { type: Number, required: true },
  deaths: { type: Number, required: true },
  active: { type: Number, required: true },
  confirmed: { type: Number, required: true },
  updateTime: { type: Number, required: true }
}, {
  collection: "history"
});

export default mongoose.model<IHistory>("Country", HistorySchema);;