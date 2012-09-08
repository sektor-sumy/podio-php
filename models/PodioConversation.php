<?php
/**
 * @see https://developers.podio.com/doc/conversations
 */
class PodioConversation extends PodioObject {
  public function __construct($attributes = array()) {
    $this->property('conversation_id', 'integer', array('id' => true));
    $this->property('subject', 'string');

    // Creating conversations
    $this->property('text', 'string');
    $this->property('participants', 'array');
    $this->property('file_ids', 'array');
    $this->property('embed_id', 'integer');
    $this->property('embed_file_id', 'integer');


    // Getting conversations
    $this->property('created_on', 'datetime');

    $this->has_one('ref', 'Reference');
    $this->has_one('embed', 'Embed');
    $this->has_one('embed_file', 'File');
    $this->has_one('created_by', 'ByLine');
    $this->has_many('files', 'File');
    $this->has_many('messages', 'ConversationMessage');
    $this->has_many('participants_full', 'ConversationParticipant');

    $this->init($attributes);
  }

  /**
   * @see https://developers.podio.com/doc/conversations/get-conversation-22369
   */
  public static function get($conversation_id) {
    return self::member(Podio::get("/conversation/{$conversation_id}"));
  }

  /**
   * @see https://developers.podio.com/doc/conversations/get-conversations-on-object-22443
   */
  public static function get_for($ref_type, $ref_id, $plugin) {
    return self::listing(Podio::get("/batch/{$ref_type}/{$ref_id}/"));
  }

  /**
   * @see https://developers.podio.com/doc/conversations/create-conversation-22441
   */
  public static function create($attributes) {
    return Podio::post("/conversation/", $attributes)->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/conversations/create-conversation-on-object-22442
   */
  public static function create_for($ref_type, $ref_id, $attributes) {
    return Podio::post("/conversation/{$ref_type}/{$ref_id}/", $attributes)->json_body();
  }

  /**
   * @see https://developers.podio.com/doc/conversations/reply-to-conversation-22444
   */
  public static function create_reply($conversation_id, $attributes) {
    $body = Podio::post("/conversation/{$conversation_id}/reply", $attributes)->json_body();
    return $body['message_id'];
  }

  /**
   * @see https://developers.podio.com/doc/conversations/add-participants-384261
   */
  public static function add_participant($conversation_id, $attributes) {
    return Podio::post("/conversation/{$conversation_id}/participant/", $attributes)->json_body();
  }

}
