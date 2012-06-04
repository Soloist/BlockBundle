# Namespace creation
window.soloist ?= {}

#
#
# BlockManager class declaration
# This class manages D&D interactions and modifications for blocks
#
class window.soloist.BlockManager

    #
    #
    # Default options (static)
    @options:
        container:    '#block-container'
        blocks:       '#block-library .draggable-block'
        library:      '#block-library'
        addUri:       ''
        configurator: {}

    #
    #
    # Construct the class
    constructor: (_options) ->
        @options    = $.extend {}, BlockManager.options, _options
        @initCollections()
        @init()

    initCollections: () ->
        @$container = jQuery @options.container
        @$blocks    = jQuery @options.blocks
        @$library   = jQuery @options.library
    #
    #
    # Initialize events and interactions
    init: () ->
        self = this
        @$container
            # Make the container be droppable for new blocks
            .droppable
                drop: (_event, _ui) ->
                    self.onDrop.call self, jQuery(this), _ui
            # Make blocs in container sortable
            .sortable
                delay: 250
                update: (event) ->
                    self.onSortableUpdate.call self, event

        # Make blocks draggable
        @$blocks.draggable
            revert: true

        # Bind delete action
        @$container.find('a.delete').click (event) ->
            self.onDeleteButtonClick.call self, jQuery(this), event

        # Bind configure action
        @$container.find('a.configure').click ->
            new window.soloist.BlockConfigurator $(this).attr 'href'
            return false

    #
    # Event listeners
    #

    #
    #
    # Listener of drop event
    onDrop: (_$droppable, _ui) ->
        self = this
        $draggable = _ui.draggable;

        # Checks if we're on a new-block and not in sortable list
        if !$draggable.hasClass 'draggable-block'
            return true

        # Launch the ajax request to add the block
        jQuery.ajax
            url:      @options.addUri
            type:     'post'
            dataType: 'json'
            data: $draggable.find('form').serialize()
            success: (data) ->
                self.onAddBlockSuccess.call self, data
            error: ->
                alert 'Impossible d\'ajouter ce bloc'

    #
    #
    # Listener of add block ajax event, refresh the block list and library
    onAddBlockSuccess: (data) ->
        @$container.html data.blocks
        @$library.html data.library
        @initCollections()
        @init()

    #
    #
    # Listener of block-deletion
    onDeleteButtonClick: ($link, event) ->
        self = this
        if not confirm 'Etes vous sur de vouloir supprimer ce bloc ?'
            return false
        jQuery.ajax
            url: $link.attr 'href'
            success: (data) ->
                self.onDeleteSuccess.call self, data
            error: ->
                alert 'Impossible de supprimer ce bloc'
        return false

    #
    #
    # Called on delete AJAX Request success
    onDeleteSuccess: (data) ->
        @$container.html data
        @initCollections()
        @init()

    #
    #
    # Called when sorting is done
    onSortableUpdate: (event) ->
        $element = jQuery event.srcElement

        # Workaround to avoid jQuery returning child element
        while not $element.hasClass 'thumbnail'
            $element = $element.parent()

        position = $element.prevAll('.thumbnail').length
        jQuery.ajax
            url: $element.attr 'data-sort-uri'
            data:
                position: position
            error: ->
                alert 'Impossible de deplacer ce bloc'


