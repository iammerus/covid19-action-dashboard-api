import History from "./models/history";
import Country from "./models/country";
/**
 * Store the latests statistics to each country's row
 *
 * @param data
 */
export function storeRawStatistics(
  data: {
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
    lastUpdate: number;
  }[]
) {
  data.forEach(async row => {
    await Country.findOneAndUpdate({ id: row.id }, { cases: row.cases }).exec();
  });
}

/**
 * Stores historical data for all countries. (Archival purposes)
 * 
 * @param data 
 */
export function storeHistoricalData(
  data: {
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
    lastUpdate: number;
  }[]
) {
  data.forEach(async row => {
    let country = await Country.findOne({ id: row.id }).exec();

    await History.create({
      countryId: country?._id,
      recovered: row.cases.recovered,
      deaths: row.cases.deaths,
      active: row.cases.active,
      confirmed: row.cases.confirmed,
      updateTime: row.lastUpdate
    });
  });
}
