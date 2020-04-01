import axios from "axios";
import { DATA_ENDPOINT } from "../config";

/**
 * Parse response from third party api
 * 
 * @param data 
 */
function parseResponse(
  data: any
): {
  id: number;
  name: string;
  latitude: number;
  longitude: number;
  cases: {
    active: number;
    confirmed: number;
    deaths: number;
    recovered: number;
  };
}[] {
  let output: {
    id: number;
    name: string;
    latitude: number;
    longitude: number;
    cases: {
      active: number;
      confirmed: number;
      deaths: number;
      recovered: number;
    };
  }[] = [];

  data.features.forEach((item: any) => {
    output.push({
      id: item.attributes.OBJECTID,
      name: item.attributes.Country_Region,
      latitude: item.attributes.Lat,
      longitude: item.attributes.Long_,
      cases: {
        active: item.attributes.Active,
        confirmed: item.attributes.Confirmed,
        deaths: item.attributes.Deaths,
        recovered: item.attributes.Recovered
      }
    });
  });

  return output;
}

/**
 * Fetches the latest data from the data endpoint
 *
 */
export async function fetchLatestData(): Promise<
  {
    id: number;
    name: string;
    latitude: number;
    longitude: number;
    cases: {
      active: number;
      confirmed: number;
      deaths: number;
      recovered: number;
    };
  }[]
> {
  // Send an HTTP request to the data endpoint
  let response = await axios.get(DATA_ENDPOINT);

  // Get the actual raw data from the response
  let data = response.data;

  // Parse and organize the data
  return parseResponse(data);
}
