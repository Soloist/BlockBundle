# Namespace creation
window.soloist ?= {}

class window.soloist.BlockConfigurator

    constructor: (uri) ->
        @$modal   = jQuery('<div class="modal"></div>')
        self     = this
        @$modal.load uri, ->
            self.$modal.modal()
            self.init()

    init: () ->
        self = this;

        @$modal.find('#configure-close').click ->
            self.$modal.modal('hide')
            return false

        @$modal.find('form').submit ->
            $.ajax
                url:  $(this).attr 'action'
                type: 'post'
                data: $(this).serialize()
                success: ->
                    self.$modal.modal('hide')
                error: ->
                    alert 'Impossible de configurer ce bloc'

            return false
