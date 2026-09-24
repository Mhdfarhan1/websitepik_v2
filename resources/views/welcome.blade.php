<x-layouts.app>
    <x-sections.hero />
    <x-sections.features />
    <x-sections.about />
    <x-sections.activities :activities="$activities" />
    <x-sections.prestasi :achievement-list="$achievementList" />
    @if(isset($featuredTribute) && $featuredTribute)
        <x-sections.tribute :tribute="$featuredTribute" :all-editions="$tributeEditions" />
    @endif
    <x-sections.news :news-list="$newsList" />
    <x-sections.gallery :gallery-list="$galleryList" />
    <x-sections.structural :structures="$structures" :settings="$structureSettings" />
    <x-sections.mitra :partners="$partners" />
    <x-sections.faq />
    <x-sections.cta />
</x-layouts.app>