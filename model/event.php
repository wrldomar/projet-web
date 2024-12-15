<?php
class event {
    
    private int $id_fermier;
    private string $nom_event;
    private string $location_event;
    private string $description;
    private DateTime $Date;
    private string $heure;
    private string $duration;
    private int $Max_Tickets;
    private float $Ticket_price;
    private bool $Status;
    private string $image_url; 

    public function __construct(int $id_fermier, string $nom_event,
        string $location_event, string $description, 
        DateTime $Date, string $heure, string $duration,
        int $Max_Tickets, float $Ticket_price, bool $Status, string $image_url)
      
      
      {
       
        $this->id_fermier = $id_fermier;
        $this->nom_event = $nom_event;
        $this->location_event = $location_event;
        $this->description = $description;
        $this->Date = $Date;
        $this->heure = $heure;
        $this->duration = $duration;
        $this->Max_Tickets = $Max_Tickets;
        $this->Ticket_price = $Ticket_price;
        $this->Status = $Status;
        $this->image_url = $image_url; 
    }

    // Add getter and setter methods for the image_url field
    public function getImageUrl():string {
        return $this->image_url;
    }

    public function setImageUrl(string $image_url): void {
        $this->image_url = $image_url;
    }

    // Add other getter and setter methods as needed
    public function getIdfermier(): int {
        return $this->id_fermier;
    }

    public function setIdfermier(int $id_fermier): void {
        $this->id_fermier = $id_fermier;
    }

    public function getNomEvent(): string {
        return $this->nom_event;
    }

    public function setNomEvent(string $nom_event): void {
        $this->nom_event = $nom_event;
    }

    public function getLocationEvent(): string {
        return $this->location_event;
    }

    public function setLocationEvent(string $location_event): void {
        $this->location_event = $location_event;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getDate(): DateTime {
        return $this->Date;
    }

    public function setDate(DateTime $Date): void {
        $this->Date = $Date;
    }

    public function getHeure(): string {
        return $this->heure;
    }

    public function setHeure(string $heure): void {
        $this->heure = $heure;
    }

    public function getDuration(): string {
        return $this->duration;
    }

    public function setDuration(string $duration): void {
        $this->duration = $duration;
    }

    public function getMaxTickets(): int {
        return $this->Max_Tickets;
    }

    public function setMaxTickets(int $Max_Tickets): void {
        $this->Max_Tickets = $Max_Tickets;
    }

    public function getTicketPrice(): float {
        return $this->Ticket_price;
    }

    public function setTicketPrice(float $Ticket_price): void {
        $this->Ticket_price = $Ticket_price;
    }

    public function getStatus(): bool {
        return $this->Status;
    }

    public function setStatus(bool $Status): void {
        $this->Status = $Status;
    }
    /*public function getIdEvent() { 
        return $this->id_event; 
    }
    public function setIdEvent($id_event) 
    { 
        $this->id_event = $id_event; 
    }*/
}
?>