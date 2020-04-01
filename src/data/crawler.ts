import axios from "axios"
import {DATA_ENDPOINT} from "../config"

/**
 * Fetches the latest data from the data endpoint
 * 
 */
export async function fetchLatestData() {
    let data = await axios.get(DATA_ENDPOINT)
}
