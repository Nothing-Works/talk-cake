<template>
    <ais-instant-search
        :search-client="searchClient"
        :routing="routing"
        index-name="threads"
    >
        <ais-search-box :autofocus="true" />
        <ais-refinement-list attribute="channel.name" />
        <ais-hits>
            <div slot="item" slot-scope="{ item }">
                <a :href="item.path">
                    <ais-highlight attribute="title" :hit="item" />
                </a>
            </div>
        </ais-hits>
    </ais-instant-search>
</template>

<script>
import algoliasearch from 'algoliasearch/lite'
import 'instantsearch.css/themes/algolia-min.css'
import { history as historyRouter } from 'instantsearch.js/es/lib/routers'
import { simple as simpleMapping } from 'instantsearch.js/es/lib/stateMappings'

export default {
    name: 'ScanView',
    data() {
        return {
            searchClient: algoliasearch(
                'PBVPLETKCZ',
                '6d718b64426a2030b9d0900a20edd300'
            ),
            routing: {
                router: historyRouter(),
                stateMapping: simpleMapping()
            }
        }
    }
}
</script>
