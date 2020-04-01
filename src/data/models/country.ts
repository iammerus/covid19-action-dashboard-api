import mongoose from "mongoose";

export interface ICountry extends mongoose.Document {
  id: number;
  name: string;
  latitude: number;
  longitude: number;
  cases: {
    recovered: number;
    active: number;
    confirmed: number;
    deaths: number;
  };
  lastUpdate: number;
}

export const CountrySchema = new mongoose.Schema({
  id: { type: Number, required: true },
  name: { type: String, required: true },
  latitude: { type: Number, required: true },
  longitude: { type: Number, required: true },
  cases: {
    type: {
      recovered: Number,
      deaths: Number,
      active: Number,
      confirmed: Number
    },
    required: true
  },
  lastUpdate: { type: Number, required: true }
}, {
  collection: "countries"
});

export default mongoose.model<ICountry>("Country", CountrySchema);;