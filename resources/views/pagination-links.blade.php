@if ($paginator->hasPages())
<ul class="w-full flex justify-center">


  <!-- Previous -->
  @if ($paginator->onFirstPage())
  <li class="px-4 py-1 text-center rounded border bg-gray-200">
    Prev
  </li>
  @else
  <li wire:click="previousPage" class="px-4 py-1 text-center rounded border shadow bg-white cursor-pointer">
    Prev
  </li>
  @endif

  <!-- previosue end -->


  <!-- number of pages -->
  @foreach($elements as $element)
  <div class="flex">
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <li class="mx-2 px-4 py-1 text-center rounded border shadow bg-blue-500 text-white cursor-pointer" wire:click="gotoPage({{ $page }})">{{ $page }}</li>
    @else
    <li class="mx-2 px-4 py-1 text-center rounded border shadow bg-white cursor-pointer" wire:click="gotoPage({{ $page }})">{{ $page }}</li>
    @endif
    @endforeach
    @endif
  </div>
  @endforeach

  <!-- number of pages end -->


  <!-- Next -->
  @if ($paginator->hasMorePages())
  <li wire:click="nextPage" class="px-4 py-1 text-center rounded border shadow bg-white cursor-pointer">
    Next
  </li>
  @else
  <li class="px-4 py-1 text-center rounded border bg-gray-200">
    Next
  </li>
  @endif
  <!-- Next end -->

</ul>
@endif